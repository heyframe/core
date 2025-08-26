<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelAnalytics;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<SalesChannelAnalyticsEntity>
 */
#[Package('discovery')]
class SalesChannelAnalyticsCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'sales_channel_analytics_collection';
    }

    protected function getExpectedClass(): string
    {
        return SalesChannelAnalyticsEntity::class;
    }
}
