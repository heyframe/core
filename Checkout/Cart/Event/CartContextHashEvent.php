<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Checkout\Cart\CartContextHashStruct;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class CartContextHashEvent extends Event implements HeyFrameSalesChannelEvent, CartEvent
{
    public function __construct(
        protected readonly SalesChannelContext $salesChannelContext,
        protected readonly Cart $cart,
        protected CartContextHashStruct $hashStruct
    ) {
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getHashStruct(): CartContextHashStruct
    {
        return $this->hashStruct;
    }

    public function setHashStruct(CartContextHashStruct $hashStruct): void
    {
        $this->hashStruct = $hashStruct;
    }
}
