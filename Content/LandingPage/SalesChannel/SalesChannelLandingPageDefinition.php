<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\LandingPage\SalesChannel;

use HeyFrame\Core\Content\LandingPage\LandingPageDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class SalesChannelLandingPageDefinition extends LandingPageDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
    }
}
