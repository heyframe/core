<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<TaxEntity>
 */
#[Package('checkout')]
class TaxCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'tax_collection';
    }

    protected function getExpectedClass(): string
    {
        return TaxEntity::class;
    }
}
