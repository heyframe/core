<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Currency\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Currency\CurrencyDefinition;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('fundamentals@framework')]
class SalesChannelCurrencyDefinition extends CurrencyDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
        $criteria->addFilter(new EqualsFilter('currency.salesChannels.id', $context->getSalesChannelId()));
    }
}
