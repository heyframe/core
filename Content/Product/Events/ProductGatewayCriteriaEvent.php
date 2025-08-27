<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Events;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
class ProductGatewayCriteriaEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    /**
     * @param array<string> $ids
     */
    public function __construct(
        protected array $ids,
        protected Criteria $criteria,
        protected SalesChannelContext $context,
    ) {
    }

    /**
     * @return array<string>
     */
    public function getIds(): array
    {
        return $this->ids;
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
