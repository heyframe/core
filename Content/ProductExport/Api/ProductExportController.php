<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Api;

use HeyFrame\Core\Content\ProductExport\Error\Error;
use HeyFrame\Core\Content\ProductExport\Event\ProductExportLoggingEvent;
use HeyFrame\Core\Content\ProductExport\Exception\SalesChannelDomainNotFoundException;
use HeyFrame\Core\Content\ProductExport\Exception\SalesChannelNotFoundException;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Content\ProductExport\Service\ProductExportGeneratorInterface;
use HeyFrame\Core\Content\ProductExport\Struct\ExportBehavior;
use HeyFrame\Core\Content\ProductExport\Struct\ProductExportResult;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Routing\ApiRouteScope;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainCollection;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainEntity;
use HeyFrame\Core\System\SalesChannel\SalesChannelCollection;
use HeyFrame\Core\System\SalesChannel\SalesChannelEntity;
use Monolog\Level;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [ApiRouteScope::ID]])]
#[Package('inventory')]
class ProductExportController extends AbstractController
{
    /**
     * @internal
     *
     * @param EntityRepository<SalesChannelDomainCollection> $salesChannelDomainRepository
     * @param EntityRepository<SalesChannelCollection> $salesChannelRepository
     */
    public function __construct(
        private readonly EntityRepository $salesChannelDomainRepository,
        private readonly EntityRepository $salesChannelRepository,
        private readonly ProductExportGeneratorInterface $productExportGenerator,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    #[Route(path: '/api/_action/product-export/validate', name: 'api.action.product_export.validate', methods: ['POST'])]
    public function validate(RequestDataBag $dataBag, Context $context): JsonResponse
    {
        $result = $this->generateExportPreview($dataBag, $context);

        if ($result && $result->hasErrors()) {
            $errors = $result->getErrors();
            $errorMessages = array_merge(
                ...array_map(
                    fn (Error $error) => $error->getErrorMessages(),
                    $errors
                )
            );

            return new JsonResponse(
                [
                    'content' => mb_convert_encoding(
                        $result->getContent(),
                        'UTF-8',
                        $dataBag->get('encoding')
                    ),
                    'errors' => $errorMessages,
                ]
            );
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/api/_action/product-export/preview', name: 'api.action.product_export.preview', methods: ['POST'])]
    public function preview(RequestDataBag $dataBag, Context $context): JsonResponse
    {
        $result = $this->generateExportPreview($dataBag, $context);

        if ($result && $result->hasErrors()) {
            $errors = $result->getErrors();
            $errorMessages = array_merge(
                ...array_map(
                    fn (Error $error) => $error->getErrorMessages(),
                    $errors
                )
            );
        }

        return new JsonResponse(
            [
                'content' => mb_convert_encoding(
                    $result ? $result->getContent() : '',
                    'UTF-8',
                    $dataBag->get('encoding')
                ),
                'errors' => $errorMessages ?? [],
            ]
        );
    }

    private function createEntity(RequestDataBag $dataBag): ProductExportEntity
    {
        $entity = new ProductExportEntity();

        $entity->setId('');
        $entity->setHeaderTemplate($dataBag->get('headerTemplate') ?? '');
        $entity->setBodyTemplate($dataBag->get('bodyTemplate') ?? '');
        $entity->setFooterTemplate($dataBag->get('footerTemplate') ?? '');
        $entity->setProductStreamId($dataBag->get('productStreamId'));
        $entity->setIncludeVariants($dataBag->get('includeVariants'));
        $entity->setEncoding($dataBag->get('encoding'));
        $entity->setFileFormat($dataBag->get('fileFormat'));
        $entity->setFileName($dataBag->get('fileName'));
        $entity->setAccessKey($dataBag->get('accessKey'));
        $entity->setSalesChannelId($dataBag->get('salesChannelId'));
        $entity->setSalesChannelDomainId($dataBag->get('salesChannelDomainId'));
        $entity->setCurrencyId($dataBag->get('currencyId'));

        return $entity;
    }

    private function generateExportPreview(RequestDataBag $dataBag, Context $context): ?ProductExportResult
    {
        $salesChannelDomain = $this->getSalesChannelDomain($dataBag->get('salesChannelDomainId'), $context);
        $salesChannel = $this->getSalesChannel($dataBag->get('salesChannelId'), $context);

        $productExportEntity = $this->createEntity($dataBag);
        $productExportEntity->setSalesChannelDomain($salesChannelDomain);
        $productExportEntity->setStorefrontSalesChannelId($salesChannelDomain->getSalesChannelId());
        $productExportEntity->setSalesChannel($salesChannel);

        $exportBehavior = new ExportBehavior(true, true, true);

        return $this->productExportGenerator->generate($productExportEntity, $exportBehavior);
    }

    private function getSalesChannelDomain(string $salesChannelDomainId, Context $context): SalesChannelDomainEntity
    {
        $criteria = (new Criteria([$salesChannelDomainId]))
            ->addAssociation('language.locale')
            ->addAssociation('salesChannel');

        $salesChannelDomain = $this->salesChannelDomainRepository->search(
            $criteria,
            $context
        )->getEntities()->get($salesChannelDomainId);

        if ($salesChannelDomain === null) {
            $salesChannelDomainNotFoundException = new SalesChannelDomainNotFoundException($salesChannelDomainId);
            $loggingEvent = new ProductExportLoggingEvent(
                $context,
                $salesChannelDomainNotFoundException->getMessage(),
                Level::Error,
                $salesChannelDomainNotFoundException
            );
            $this->eventDispatcher->dispatch($loggingEvent);

            throw $salesChannelDomainNotFoundException;
        }

        return $salesChannelDomain;
    }

    private function getSalesChannel(string $salesChannelId, Context $context): SalesChannelEntity
    {
        $criteria = new Criteria([$salesChannelId]);

        $salesChannel = $this->salesChannelRepository->search(
            $criteria,
            $context
        )->getEntities()->get($salesChannelId);

        if ($salesChannel === null) {
            $salesChannelNotFoundException = new SalesChannelNotFoundException($salesChannelId);
            $loggingEvent = new ProductExportLoggingEvent(
                $context,
                $salesChannelNotFoundException->getMessage(),
                Level::Error,
                $salesChannelNotFoundException
            );
            $this->eventDispatcher->dispatch($loggingEvent);

            throw $salesChannelNotFoundException;
        }

        return $salesChannel;
    }
}
