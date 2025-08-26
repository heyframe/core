<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\SalesChannel;

use League\Flysystem\FilesystemOperator;
use Monolog\Level;
use HeyFrame\Core\Content\ProductExport\Event\ProductExportContentTypeEvent;
use HeyFrame\Core\Content\ProductExport\Event\ProductExportLoggingEvent;
use HeyFrame\Core\Content\ProductExport\Exception\ExportNotFoundException;
use HeyFrame\Core\Content\ProductExport\Exception\ExportNotGeneratedException;
use HeyFrame\Core\Content\ProductExport\ProductExportCollection;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Content\ProductExport\ProductExportException;
use HeyFrame\Core\Content\ProductExport\Service\ProductExporterInterface;
use HeyFrame\Core\Content\ProductExport\Service\ProductExportFileHandlerInterface;
use HeyFrame\Core\Content\ProductExport\Struct\ExportBehavior;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Context\AbstractSalesChannelContextFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('inventory')]
class ExportController
{
    /**
     * @internal
     *
     * @param EntityRepository<ProductExportCollection> $productExportRepository
     */
    public function __construct(
        private readonly ProductExporterInterface $productExportService,
        private readonly ProductExportFileHandlerInterface $productExportFileHandler,
        private readonly FilesystemOperator $fileSystem,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly EntityRepository $productExportRepository,
        private readonly AbstractSalesChannelContextFactory $contextFactory
    ) {
    }

    #[Route(path: '/store-api/product-export/{accessKey}/{fileName}', name: 'store-api.product.export', methods: ['GET'], defaults: ['auth_required' => false])]
    public function index(Request $request): Response
    {
        $context = Context::createDefaultContext();

        $criteria = new Criteria();
        $criteria
            ->addFilter(new EqualsFilter('fileName', $request->get('fileName')))
            ->addFilter(new EqualsFilter('accessKey', $request->get('accessKey')))
            ->addFilter(new EqualsFilter('salesChannel.active', true))
            ->addAssociation('salesChannelDomain');

        $productExport = $this->productExportRepository->search($criteria, $context)->getEntities()->first();

        if ($productExport === null) {
            $exportNotFoundException = new ExportNotFoundException(null, $request->get('fileName'));
            $this->logException($context, $exportNotFoundException, Level::Warning);

            throw $exportNotFoundException;
        }

        $domain = $productExport->getSalesChannelDomain();

        if ($domain === null) {
            throw ProductExportException::salesChannelDomainNotFound($productExport->getId());
        }

        $context = $this->contextFactory->create('', $domain->getSalesChannelId());

        $filePath = $this->productExportFileHandler->getFilePath($productExport);

        // if file not present or interval = live
        if (!$this->fileSystem->fileExists($filePath) || $productExport->getInterval() === 0) {
            $this->productExportService->export($context, new ExportBehavior(), $productExport->getId());
        }

        if (!$this->fileSystem->fileExists($filePath)) {
            $exportNotGeneratedException = new ExportNotGeneratedException();
            $this->logException($context->getContext(), $exportNotGeneratedException);

            throw $exportNotGeneratedException;
        }

        $content = $this->fileSystem->read($filePath);
        $contentType = $this->getContentType($productExport->getFileFormat());
        $encoding = $productExport->getEncoding();

        $response = new Response($content ?: null, Response::HTTP_OK, ['Content-Type' => $contentType . ';charset=' . $encoding]);
        $response->setLastModified((new \DateTimeImmutable())->setTimestamp($this->fileSystem->lastModified($filePath)));
        $response->setCharset($encoding);

        return $response;
    }

    private function getContentType(string $fileFormat): string
    {
        $contentType = 'text/plain';

        switch ($fileFormat) {
            case ProductExportEntity::FILE_FORMAT_CSV:
                $contentType = 'text/csv';

                break;
            case ProductExportEntity::FILE_FORMAT_XML:
                $contentType = 'text/xml';

                break;
        }

        $event = new ProductExportContentTypeEvent($fileFormat, $contentType);
        $this->eventDispatcher->dispatch($event);

        return $event->getContentType();
    }

    private function logException(
        Context $context,
        \Exception $exception,
        Level $logLevel = Level::Error
    ): void {
        $loggingEvent = new ProductExportLoggingEvent(
            $context,
            $exception->getMessage(),
            $logLevel,
            $exception
        );

        $this->eventDispatcher->dispatch($loggingEvent);
    }
}
