<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\SalesChannel;

use HeyFrame\Core\Content\Cms\CmsPageEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<CmsPageEntity>
 */
#[Package('discovery')]
class CmsRouteResponse extends StoreApiResponse
{
    public function getCmsPage(): CmsPageEntity
    {
        return $this->object;
    }
}
