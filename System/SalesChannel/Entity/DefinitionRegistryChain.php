<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Entity;

use HeyFrame\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Exception\DefinitionNotFoundException;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Exception\SalesChannelRepositoryNotFoundException;

/**
 * @internal
 */
#[Package('framework')]
class DefinitionRegistryChain
{
    public function __construct(
        private readonly DefinitionInstanceRegistry $core,
        private readonly SalesChannelDefinitionInstanceRegistry $salesChannel
    ) {
    }

    public function get(string $class): EntityDefinition
    {
        if ($this->salesChannel->has($class)) {
            return $this->salesChannel->get($class);
        }

        return $this->core->get($class);
    }

    /**
     * @return EntityRepository<covariant EntityCollection<covariant Entity>>|SalesChannelRepository<covariant EntityCollection<covariant Entity>>
     */
    public function getRepository(string $entity): EntityRepository|SalesChannelRepository
    {
        try {
            return $this->salesChannel->getSalesChannelRepository($entity);
        } catch (SalesChannelRepositoryNotFoundException) {
            return $this->core->getRepository($entity);
        }
    }

    public function getByEntityName(string $type): EntityDefinition
    {
        try {
            return $this->salesChannel->getByEntityName($type);
        } catch (DefinitionNotFoundException) {
            return $this->core->getByEntityName($type);
        }
    }

    public function has(string $type): bool
    {
        return $this->salesChannel->has($type) || $this->core->has($type);
    }
}
