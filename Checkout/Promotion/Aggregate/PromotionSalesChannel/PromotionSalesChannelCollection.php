<?php
declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Promotion\Aggregate\PromotionSalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<PromotionSalesChannelEntity>
 */
#[Package('checkout')]
class PromotionSalesChannelCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'promotion_sales_channel_collection';
    }

    protected function getExpectedClass(): string
    {
        return PromotionSalesChannelEntity::class;
    }
}
