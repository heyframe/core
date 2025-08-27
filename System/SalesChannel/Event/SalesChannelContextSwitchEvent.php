<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\DataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
class SalesChannelContextSwitchEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        private readonly SalesChannelContext $salesChannelContext,
        private readonly DataBag $requestDataBag
    ) {
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getRequestDataBag(): DataBag
    {
        return $this->requestDataBag;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
