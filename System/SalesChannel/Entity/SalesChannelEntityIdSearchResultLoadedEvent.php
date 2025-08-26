<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntityIdSearchResultLoadedEvent;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\IdSearchResult;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class SalesChannelEntityIdSearchResultLoadedEvent extends EntityIdSearchResultLoadedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        EntityDefinition $definition,
        IdSearchResult $result,
        private readonly SalesChannelContext $salesChannelContext
    ) {
        parent::__construct($definition, $result);
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
