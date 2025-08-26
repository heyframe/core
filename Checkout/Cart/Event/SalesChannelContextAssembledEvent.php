<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Order\OrderEntity;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Allows the manipulation of the sales channel context after it was assembled from the order
 */
#[Package('checkout')]
class SalesChannelContextAssembledEvent extends Event implements HeyFrameSalesChannelEvent
{
    /**
     * @internal
     */
    public function __construct(
        private readonly OrderEntity $order,
        private readonly SalesChannelContext $salesChannelContext,
    ) {
    }

    public function getOrder(): OrderEntity
    {
        return $this->order;
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
