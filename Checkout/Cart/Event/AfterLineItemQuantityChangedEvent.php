<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class AfterLineItemQuantityChangedEvent implements HeyFrameSalesChannelEvent, CartEvent
{
    /**
     * @param array<array<string, mixed>> $items
     */
    public function __construct(
        protected Cart $cart,
        protected array $items,
        protected SalesChannelContext $salesChannelContext
    ) {
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
