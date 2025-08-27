<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Events;

use HeyFrame\Core\Content\Product\SalesChannel\Listing\ProductListingResult;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
class ProductListingResultEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected Request $request,
        protected ProductListingResult $result,
        protected SalesChannelContext $context,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getContext(): Context
    {
        return $this->context->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->context;
    }

    public function getResult(): ProductListingResult
    {
        return $this->result;
    }
}
