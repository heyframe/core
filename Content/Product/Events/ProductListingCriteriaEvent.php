<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Events;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
class ProductListingCriteriaEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected Request $request,
        protected Criteria $criteria,
        protected SalesChannelContext $context,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getCriteria(): Criteria
    {
        return $this->criteria;
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
