<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Validator;

use HeyFrame\Core\Content\ProductExport\Error\ErrorCollection;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
interface ValidatorInterface
{
    public function validate(ProductExportEntity $productExportEntity, string $productExportContent, ErrorCollection $errors): void;
}
