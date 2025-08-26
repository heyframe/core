<?php declare(strict_types=1);

namespace HeyFrame\Core\System\DeliveryTime;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<DeliveryTimeEntity>
 */
#[Package('discovery')]
class DeliveryTimeCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'delivery_time_collection';
    }

    protected function getExpectedClass(): string
    {
        return DeliveryTimeEntity::class;
    }
}
