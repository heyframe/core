<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax\TaxRuleType;

use HeyFrame\Core\Checkout\Cart\Delivery\Struct\ShippingLocation;
use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tax\Aggregate\TaxRule\TaxRuleEntity;

#[Package('checkout')]
interface TaxRuleTypeFilterInterface
{
    public function match(TaxRuleEntity $taxRuleEntity, ?CustomerEntity $customer, ShippingLocation $shippingLocation): bool;
}
