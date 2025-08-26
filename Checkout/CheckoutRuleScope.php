<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Rule\RuleScope;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class CheckoutRuleScope extends RuleScope
{
    public function __construct(
        protected SalesChannelContext $context
    ) {
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->context;
    }

    public function getContext(): Context
    {
        return $this->context->getContext();
    }
}
