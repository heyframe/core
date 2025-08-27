<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Review\Event;

use HeyFrame\Core\Content\Product\SalesChannel\Review\ProductReviewResult;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('after-sales')]
final class ProductReviewsLoadedEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        public ProductReviewResult $reviews,
        public Request $request,
        protected SalesChannelContext $salesChannelContext,
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
}
