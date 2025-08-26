<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\CrossSelling;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<CrossSellingElementCollection>
 */
#[Package('inventory')]
class ProductCrossSellingRouteResponse extends StoreApiResponse
{
    public function getResult(): CrossSellingElementCollection
    {
        return $this->object;
    }
}
