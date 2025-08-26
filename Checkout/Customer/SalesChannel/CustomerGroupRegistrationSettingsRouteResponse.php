<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\Aggregate\CustomerGroup\CustomerGroupEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<CustomerGroupEntity>
 */
#[Package('checkout')]
class CustomerGroupRegistrationSettingsRouteResponse extends StoreApiResponse
{
    public function getRegistration(): CustomerGroupEntity
    {
        return $this->object;
    }
}
