<?php

declare(strict_types=1);

namespace HeyFrame\Core\System\Tax\TaxRuleType;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tax\Aggregate\TaxRule\TaxRuleEntity;

#[Package('checkout')]
abstract class AbstractTaxRuleTypeFilter implements TaxRuleTypeFilterInterface
{
    protected function isTaxActive(TaxRuleEntity $taxRuleEntity): bool
    {
        return $taxRuleEntity->getActiveFrom() < (new \DateTime())->setTimezone(new \DateTimeZone('UTC'));
    }
}
