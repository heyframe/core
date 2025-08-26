<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntityAggregationResultLoadedEvent;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResultCollection;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class SalesChannelEntityAggregationResultLoadedEvent extends EntityAggregationResultLoadedEvent implements HeyFrameSalesChannelEvent
{
    private readonly SalesChannelContext $salesChannelContext;

    public function __construct(
        EntityDefinition $definition,
        AggregationResultCollection $result,
        SalesChannelContext $salesChannelContext
    ) {
        parent::__construct($definition, $result, $salesChannelContext->getContext());
        $this->salesChannelContext = $salesChannelContext;
    }

    public function getName(): string
    {
        return 'sales_channel.' . parent::getName();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
