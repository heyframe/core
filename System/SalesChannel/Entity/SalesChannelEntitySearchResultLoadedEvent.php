<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntitySearchResultLoadedEvent;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @template TEntityCollection of EntityCollection
 *
 * @extends EntitySearchResultLoadedEvent<TEntityCollection>
 */
#[Package('discovery')]
class SalesChannelEntitySearchResultLoadedEvent extends EntitySearchResultLoadedEvent implements HeyFrameSalesChannelEvent
{
    /**
     * @param EntitySearchResult<TEntityCollection> $result
     */
    public function __construct(
        EntityDefinition $definition,
        EntitySearchResult $result,
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
