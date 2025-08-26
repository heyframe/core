<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Rule;

use HeyFrame\Core\Checkout\CheckoutRuleScope;
use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Rule\Rule;
use HeyFrame\Core\Framework\Rule\RuleConfig;
use HeyFrame\Core\Framework\Rule\RuleConstraints;
use HeyFrame\Core\Framework\Rule\RuleScope;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @final
 */
#[Package('fundamentals@after-sales')]
class IsNewsletterRecipientRule extends Rule
{
    final public const RULE_NAME = 'customerIsNewsletterRecipient';

    /**
     * @internal
     */
    public function __construct(protected bool $isNewsletterRecipient = true)
    {
        parent::__construct();
    }

    public function match(RuleScope $scope): bool
    {
        if (!$scope instanceof CheckoutRuleScope) {
            return false;
        }

        if (!$customer = $scope->getSalesChannelContext()->getCustomer()) {
            return false;
        }

        if ($this->isNewsletterRecipient) {
            return $this->matchIsNewsletterRecipient($customer, $scope->getSalesChannelContext());
        }

        return !$this->matchIsNewsletterRecipient($customer, $scope->getSalesChannelContext());
    }

    public function getConstraints(): array
    {
        return [
            'isNewsletterRecipient' => RuleConstraints::bool(true),
        ];
    }

    public function getConfig(): RuleConfig
    {
        return (new RuleConfig())
            ->booleanField('isNewsletterRecipient');
    }

    private function matchIsNewsletterRecipient(CustomerEntity $customer, SalesChannelContext $context): bool
    {
        $salesChannelIds = $customer->getNewsletterSalesChannelIds();

        return \is_array($salesChannelIds) && \in_array($context->getSalesChannelId(), $salesChannelIds, true);
    }
}
