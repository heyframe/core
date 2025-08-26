<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Service;

use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Content\ProductExport\Struct\ExportBehavior;
use HeyFrame\Core\Content\ProductExport\Struct\ProductExportResult;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
interface ProductExportGeneratorInterface
{
    public function generate(
        ProductExportEntity $productExport,
        ExportBehavior $exportBehavior
    ): ?ProductExportResult;
}
