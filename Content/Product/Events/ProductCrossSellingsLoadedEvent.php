<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Events;

use HeyFrame\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElementCollection;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('inventory')]
class ProductCrossSellingsLoadedEvent extends Event implements HeyFrameSalesChannelEvent
{
    public function __construct(
        private readonly CrossSellingElementCollection $result,
        private readonly SalesChannelContext $salesChannelContext
    ) {
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getCrossSellings(): CrossSellingElementCollection
    {
        return $this->result;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
