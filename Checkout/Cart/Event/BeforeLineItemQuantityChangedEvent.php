<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Checkout\Cart\LineItem\LineItem;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class BeforeLineItemQuantityChangedEvent implements HeyFrameSalesChannelEvent, CartEvent
{
    public function __construct(
        protected readonly LineItem $lineItem,
        protected readonly Cart $cart,
        protected readonly SalesChannelContext $salesChannelContext,
        protected readonly int $beforeUpdateQuantity
    ) {
    }

    public function getLineItem(): LineItem
    {
        return $this->lineItem;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getBeforeUpdateQuantity(): int
    {
        return $this->beforeUpdateQuantity;
    }
}
