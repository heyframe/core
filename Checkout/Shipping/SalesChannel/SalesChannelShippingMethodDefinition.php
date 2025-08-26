<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Shipping\SalesChannel;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class SalesChannelShippingMethodDefinition extends ShippingMethodDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
        $criteria->addFilter(new EqualsFilter('shipping_method.salesChannels.id', $context->getSalesChannelId()));
    }
}
