<?php

declare(strict_types=1);

namespace HeyFrame\Core\Content\Seo;

use HeyFrame\Core\Content\Seo\SeoUrlRoute\SeoUrlMapping;
use HeyFrame\Core\Content\Seo\SeoUrlRoute\SeoUrlRouteConfig;
use HeyFrame\Core\Content\Seo\SeoUrlRoute\SeoUrlRouteInterface;
use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelEntity;

#[Package('inventory')]
class ConfiguredSeoUrlRoute implements SeoUrlRouteInterface
{
    public function __construct(
        private readonly SeoUrlRouteInterface $decorated,
        private readonly SeoUrlRouteConfig $config
    ) {
    }

    public function getConfig(): SeoUrlRouteConfig
    {
        return $this->config;
    }

    public function prepareCriteria(Criteria $criteria, SalesChannelEntity $salesChannel): void
    {
        $this->decorated->prepareCriteria($criteria, $salesChannel);
    }

    public function getMapping(Entity $entity, ?SalesChannelEntity $salesChannel): SeoUrlMapping
    {
        return $this->decorated->getMapping($entity, $salesChannel);
    }
}
