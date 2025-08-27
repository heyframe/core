<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Category\Event;

use HeyFrame\Core\Content\Category\Tree\Tree;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class NavigationLoadedEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected Tree $navigation,
        protected SalesChannelContext $salesChannelContext,
    ) {
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getNavigation(): Tree
    {
        return $this->navigation;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
