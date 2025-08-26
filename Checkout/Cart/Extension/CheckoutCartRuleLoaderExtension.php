<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Extension;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Checkout\Cart\CartBehavior;
use HeyFrame\Core\Checkout\Cart\Event\CartEvent;
use HeyFrame\Core\Checkout\Cart\RuleLoaderResult;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Extensions\Extension;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @codeCoverageIgnore
 *
 * @extends Extension<RuleLoaderResult>
 */
#[Package('checkout')]
final class CheckoutCartRuleLoaderExtension extends Extension implements HeyFrameSalesChannelEvent, CartEvent
{
    public const NAME = 'checkout.cart.rule-load';

    /**
     * @internal heyframe owns the __constructor, but the properties are public API
     */
    public function __construct(
        public readonly SalesChannelContext $salesChannelContext,
        public readonly Cart $originalCart,
        public readonly CartBehavior $cartBehavior,
        protected readonly bool $new,
    ) {
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getCart(): Cart
    {
        return $this->originalCart;
    }
}
