<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\FindVariant;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<FoundCombination>
 */
#[Package('inventory')]
class FindProductVariantRouteResponse extends StoreApiResponse
{
    public function getFoundCombination(): FoundCombination
    {
        return $this->object;
    }
}
