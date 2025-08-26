<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Seo\MainCategory\SalesChannel;

use HeyFrame\Core\Content\Seo\MainCategory\MainCategoryDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
class SalesChannelMainCategoryDefinition extends MainCategoryDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
        $criteria->addFilter(new EqualsFilter('salesChannelId', $context->getSalesChannelId()));
    }
}
