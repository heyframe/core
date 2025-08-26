<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Rule;

use HeyFrame\Core\Checkout\CheckoutRuleScope;
use HeyFrame\Core\Framework\Api\Context\AdminSalesChannelApiSource;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Rule\Rule;
use HeyFrame\Core\Framework\Rule\RuleConfig;
use HeyFrame\Core\Framework\Rule\RuleConstraints;
use HeyFrame\Core\Framework\Rule\RuleScope;

/**
 * @final
 */
#[Package('fundamentals@after-sales')]
class AdminSalesChannelSourceRule extends Rule
{
    final public const RULE_NAME = 'adminSalesChannelSource';

    /**
     * @internal
     */
    public function __construct(protected bool $hasAdminSalesChannelSource = false)
    {
        parent::__construct();
    }

    public function match(RuleScope $scope): bool
    {
        if (!$scope instanceof CheckoutRuleScope) {
            return false;
        }

        $hasAdminSalesChannelSource = $scope->getContext()->getSource() instanceof AdminSalesChannelApiSource;

        if ($this->hasAdminSalesChannelSource) {
            return $hasAdminSalesChannelSource;
        }

        return !$hasAdminSalesChannelSource;
    }

    public function getConstraints(): array
    {
        return [
            'hasAdminSalesChannelSource' => RuleConstraints::bool(),
        ];
    }

    public function getConfig(): RuleConfig
    {
        return (new RuleConfig())->booleanField('hasAdminSalesChannelSource');
    }
}
