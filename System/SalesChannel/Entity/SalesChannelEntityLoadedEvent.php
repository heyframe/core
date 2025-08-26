<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @template TEntity of Entity
 *
 * @extends EntityLoadedEvent<TEntity>
 */
#[Package('discovery')]
class SalesChannelEntityLoadedEvent extends EntityLoadedEvent implements HeyFrameSalesChannelEvent
{
    private readonly SalesChannelContext $salesChannelContext;

    /**
     * @param TEntity[] $entities
     */
    public function __construct(
        EntityDefinition $definition,
        array $entities,
        SalesChannelContext $context
    ) {
        parent::__construct($definition, $entities, $context->getContext());
        $this->salesChannelContext = $context;
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
