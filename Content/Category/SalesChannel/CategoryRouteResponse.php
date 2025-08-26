<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Category\SalesChannel;

use HeyFrame\Core\Content\Category\CategoryEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<CategoryEntity>
 */
#[Package('discovery')]
class CategoryRouteResponse extends StoreApiResponse
{
    public function getCategory(): CategoryEntity
    {
        return $this->object;
    }
}
