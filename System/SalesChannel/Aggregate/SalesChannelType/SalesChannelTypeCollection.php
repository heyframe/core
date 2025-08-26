<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelType;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelCollection;

/**
 * @extends EntityCollection<SalesChannelTypeEntity>
 */
#[Package('discovery')]
class SalesChannelTypeCollection extends EntityCollection
{
    public function getSalesChannels(): SalesChannelCollection
    {
        return new SalesChannelCollection(
            $this->fmap(fn (SalesChannelTypeEntity $salesChannel) => $salesChannel->getSalesChannels())
        );
    }

    public function getApiAlias(): string
    {
        return 'sales_channel_type_collection';
    }

    protected function getExpectedClass(): string
    {
        return SalesChannelTypeEntity::class;
    }
}
