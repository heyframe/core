<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Unit;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<UnitEntity>
 */
#[Package('inventory')]
class UnitCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'unit_collection';
    }

    protected function getExpectedClass(): string
    {
        return UnitEntity::class;
    }
}
