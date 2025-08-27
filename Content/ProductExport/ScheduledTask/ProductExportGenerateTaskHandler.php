<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\ScheduledTask;

use HeyFrame\Core\Content\ProductExport\ProductExportCollection;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskCollection;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\SalesChannel\Context\AbstractSalesChannelContextFactory;
use HeyFrame\Core\System\SalesChannel\SalesChannelCollection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @internal
 */
#[AsMessageHandler(handles: ProductExportGenerateTask::class)]
#[Package('inventory')]
final class ProductExportGenerateTaskHandler extends ScheduledTaskHandler
{
    /**
     * @internal
     *
     * @param EntityRepository<ScheduledTaskCollection> $scheduledTaskRepository
     * @param EntityRepository<SalesChannelCollection> $salesChannelRepository
     * @param EntityRepository<ProductExportCollection> $productExportRepository
     */
    public function __construct(
        EntityRepository $scheduledTaskRepository,
        LoggerInterface $logger,
        private readonly AbstractSalesChannelContextFactory $salesChannelContextFactory,
        private readonly EntityRepository $salesChannelRepository,
        private readonly EntityRepository $productExportRepository,
        private readonly MessageBusInterface $messageBus
    ) {
        parent::__construct($scheduledTaskRepository, $logger);
    }

    public function run(): void
    {
        $salesChannelIds = $this->fetchSalesChannelIds();

        foreach ($salesChannelIds as $salesChannelId) {
            $productExports = $this->fetchProductExports($salesChannelId);

            if ($productExports->count() === 0) {
                continue;
            }

            $now = new \DateTimeImmutable('now');

            foreach ($productExports as $productExport) {
                if (!$this->shouldBeRun($productExport, $now)) {
                    continue;
                }

                $this->messageBus->dispatch(
                    new ProductExportPartialGeneration($productExport->getId(), $salesChannelId)
                );
            }
        }
    }

    /**
     * @return array<string>
     */
    private function fetchSalesChannelIds(): array
    {
        $criteria = new Criteria();
        $criteria
            ->addFilter(new EqualsFilter('typeId', Defaults::SALES_CHANNEL_TYPE_STOREFRONT))
            ->addFilter(new EqualsFilter('active', true));

        /**
         * @var array<string>
         */
        return $this->salesChannelRepository
            ->searchIds($criteria, Context::createCLIContext())
            ->getIds();
    }

    private function fetchProductExports(string $salesChannelId): ProductExportCollection
    {
        $salesChannelContext = $this->salesChannelContextFactory->create(Uuid::randomHex(), $salesChannelId);

        $criteria = new Criteria();
        $criteria
            ->addAssociation('salesChannel')
            ->addFilter(
                new MultiFilter(
                    'AND',
                    [
                        new EqualsFilter('generateByCronjob', true),
                        new EqualsFilter('salesChannel.active', true),
                    ]
                )
            )
            ->addFilter(
                new MultiFilter(
                    'OR',
                    [
                        new EqualsFilter('storefrontSalesChannelId', $salesChannelId),
                        new EqualsFilter('salesChannelDomain.salesChannel.id', $salesChannelId),
                    ]
                )
            );

        return $this->productExportRepository->search($criteria, $salesChannelContext->getContext())->getEntities();
    }

    private function shouldBeRun(ProductExportEntity $productExport, \DateTimeImmutable $now): bool
    {
        if ($productExport->getIsRunning()) {
            return false;
        }

        if ($productExport->getGeneratedAt() === null) {
            return true;
        }

        return $now->getTimestamp() - $productExport->getGeneratedAt()->getTimestamp() >= $productExport->getInterval();
    }
}
