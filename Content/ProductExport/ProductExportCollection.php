<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<ProductExportEntity>
 */
#[Package('inventory')]
class ProductExportCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'product_export_collection';
    }

    protected function getExpectedClass(): string
    {
        return ProductExportEntity::class;
    }
}
