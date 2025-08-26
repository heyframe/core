<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\EventListener;

use League\Flysystem\FilesystemOperator;
use HeyFrame\Core\Content\ProductExport\ProductExportCollection;
use HeyFrame\Core\Content\ProductExport\Service\ProductExportFileHandlerInterface;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityWriteResult;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @internal
 */
#[Package('inventory')]
class ProductExportEventListener implements EventSubscriberInterface
{
    /**
     * @internal
     *
     * @param EntityRepository<ProductExportCollection> $productExportRepository
     */
    public function __construct(
        private readonly EntityRepository $productExportRepository,
        private readonly ProductExportFileHandlerInterface $productExportFileHandler,
        private readonly FilesystemOperator $fileSystem
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'product_export.written' => 'afterWrite',
        ];
    }

    public function afterWrite(EntityWrittenEvent $event): void
    {
        foreach ($event->getWriteResults() as $writeResult) {
            if (!$this->productExportWritten($writeResult)) {
                continue;
            }

            $primaryKey = $writeResult->getPrimaryKey();
            $primaryKey = \is_array($primaryKey) ? $primaryKey['id'] : $primaryKey;

            $this->productExportRepository->update(
                [
                    [
                        'id' => $primaryKey,
                        'generatedAt' => null,
                    ],
                ],
                $event->getContext()
            );

            $productExport = $this->productExportRepository->search(new Criteria([$primaryKey]), $event->getContext())->getEntities()->first();
            if (!$productExport) {
                continue;
            }

            $filePath = $this->productExportFileHandler->getFilePath($productExport);
            if ($this->fileSystem->fileExists($filePath)) {
                $this->fileSystem->delete($filePath);
            }
        }
    }

    private function productExportWritten(EntityWriteResult $writeResult): bool
    {
        return $writeResult->getEntityName() === 'product_export'
            && $writeResult->getOperation() !== EntityWriteResult::OPERATION_DELETE
            && !\array_key_exists('generatedAt', $writeResult->getPayload());
    }
}
