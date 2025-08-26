<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\DataResolver\Element;

use HeyFrame\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use HeyFrame\Core\Content\Cms\DataResolver\CriteriaCollection;
use HeyFrame\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use HeyFrame\Core\Framework\Log\Package;

#[Package('discovery')]
interface CmsElementResolverInterface
{
    public function getType(): string;

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection;

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void;
}
