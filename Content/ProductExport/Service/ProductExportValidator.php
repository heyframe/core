<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Service;

use HeyFrame\Core\Content\ProductExport\Error\Error;
use HeyFrame\Core\Content\ProductExport\Error\ErrorCollection;
use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Content\ProductExport\Validator\ValidatorInterface;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class ProductExportValidator implements ProductExportValidatorInterface
{
    /**
     * @internal
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(private readonly iterable $validators)
    {
    }

    /**
     * @return list<Error>
     */
    public function validate(ProductExportEntity $productExportEntity, string $productExportContent): array
    {
        $errors = new ErrorCollection();
        foreach ($this->validators as $validator) {
            $validator->validate($productExportEntity, $productExportContent, $errors);
        }

        return array_values($errors->getElements());
    }
}
