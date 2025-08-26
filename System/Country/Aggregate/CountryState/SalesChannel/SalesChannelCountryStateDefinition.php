<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Country\Aggregate\CountryState\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Country\Aggregate\CountryState\CountryStateDefinition;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('fundamentals@discovery')]
class SalesChannelCountryStateDefinition extends CountryStateDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
        $criteria->addFilter(
            new EqualsFilter('country_state.country.salesChannels.id', $context->getSalesChannelId())
        );
    }
}
