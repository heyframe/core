<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\PartialEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @extends SalesChannelEntityLoadedEvent<PartialEntity>
 */
#[Package('discovery')]
class PartialSalesChannelEntityLoadedEvent extends SalesChannelEntityLoadedEvent
{
    /**
     * @param PartialEntity[] $entities
     */
    public function __construct(
        EntityDefinition $definition,
        array $entities,
        SalesChannelContext $context
    ) {
        parent::__construct($definition, $entities, $context);

        $this->name = $this->definition->getEntityName() . '.partial_loaded';
    }
}
