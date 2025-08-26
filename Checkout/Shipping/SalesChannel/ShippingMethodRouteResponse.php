<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Shipping\SalesChannel;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<ShippingMethodCollection>>
 */
#[Package('checkout')]
class ShippingMethodRouteResponse extends StoreApiResponse
{
    public function getShippingMethods(): ShippingMethodCollection
    {
        return $this->object->getEntities();
    }
}
