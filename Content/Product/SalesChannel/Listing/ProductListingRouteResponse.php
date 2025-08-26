<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Listing;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<ProductListingResult>
 */
#[Package('inventory')]
class ProductListingRouteResponse extends StoreApiResponse
{
    public function getResult(): ProductListingResult
    {
        return $this->object;
    }
}
