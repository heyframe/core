<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Service;

use HeyFrame\Core\Content\ProductExport\Exception\ExportInvalidException;
use HeyFrame\Core\Content\ProductExport\Exception\ExportNotFoundException;
use HeyFrame\Core\Content\ProductExport\Struct\ExportBehavior;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
interface ProductExporterInterface
{
    /**
     * @throws ExportInvalidException
     * @throws ExportNotFoundException
     */
    public function export(
        SalesChannelContext $context,
        ExportBehavior $behavior,
        ?string $productExportId = null
    ): void;
}
