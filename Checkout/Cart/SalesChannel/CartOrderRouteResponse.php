<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\SalesChannel;

use HeyFrame\Core\Checkout\Order\OrderEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<OrderEntity>
 */
#[Package('checkout')]
class CartOrderRouteResponse extends StoreApiResponse
{
    public function getOrder(): OrderEntity
    {
        return $this->object;
    }
}
