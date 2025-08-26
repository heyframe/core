<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\Aggregate\CustomerAddress\CustomerAddressCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<CustomerAddressCollection>>
 */
#[Package('checkout')]
class ListAddressRouteResponse extends StoreApiResponse
{
    public function getAddressCollection(): CustomerAddressCollection
    {
        return $this->object->getEntities();
    }
}
