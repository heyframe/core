<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Validator;

use HeyFrame\Core\Content\ProductExport\Error\ErrorCollection;
use HeyFrame\Core\Content\ProductExport\Error\XmlValidationError;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class XmlValidator implements ValidatorInterface
{
    public function validate(ProductExportEntity $productExportEntity, string $productExportContent, ErrorCollection $errors): void
    {
        if ($productExportEntity->getFileFormat() !== ProductExportEntity::FILE_FORMAT_XML) {
            return;
        }

        $backup_errors = libxml_use_internal_errors(true);

        if (simplexml_load_string($productExportContent) === false) {
            $errors->add(new XmlValidationError($productExportEntity->getId(), libxml_get_errors()));
        }

        libxml_use_internal_errors($backup_errors);
    }
}
