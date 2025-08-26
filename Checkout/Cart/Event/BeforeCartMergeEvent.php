<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Checkout\Cart\LineItem\LineItemCollection;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class BeforeCartMergeEvent extends Event implements HeyFrameSalesChannelEvent
{
    /**
     * @internal
     */
    public function __construct(
        protected Cart $customerCart,
        protected Cart $guestCart,
        protected LineItemCollection $mergeableLineItems,
        protected SalesChannelContext $context
    ) {
    }

    public function getCustomerCart(): Cart
    {
        return $this->customerCart;
    }

    public function getGuestCart(): Cart
    {
        return $this->guestCart;
    }

    public function getMergeableLineItems(): LineItemCollection
    {
        return $this->mergeableLineItems;
    }

    public function getContext(): Context
    {
        return $this->context->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->context;
    }
}
