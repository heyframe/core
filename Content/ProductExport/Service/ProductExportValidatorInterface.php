<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Service;

use HeyFrame\Core\Content\ProductExport\Error\Error;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
interface ProductExportValidatorInterface
{
    /**
     * @return list<Error>
     */
    public function validate(ProductExportEntity $productExportEntity, string $productExportContent): array;
}
