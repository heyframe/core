<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Events;

use HeyFrame\Core\Content\Product\SalesChannel\Listing\FilterCollection;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
class ProductListingCollectFilterEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected Request $request,
        protected FilterCollection $filters,
        protected SalesChannelContext $context,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getFilters(): FilterCollection
    {
        return $this->filters;
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
