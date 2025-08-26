<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Suggest;

use HeyFrame\Core\Content\Product\SalesChannel\Listing\ProductListingResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<ProductListingResult>
 */
#[Package('discovery')]
class ProductSuggestRouteResponse extends StoreApiResponse
{
    public function getListingResult(): ProductListingResult
    {
        return $this->object;
    }
}
