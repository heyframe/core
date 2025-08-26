<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Payment\SalesChannel;

use HeyFrame\Core\Checkout\Payment\PaymentMethodDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class SalesChannelPaymentMethodDefinition extends PaymentMethodDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
        $criteria->addFilter(new EqualsFilter('payment_method.salesChannels.id', $context->getSalesChannelId()));
    }
}
