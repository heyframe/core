<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\LandingPage\SalesChannel;

use HeyFrame\Core\Content\LandingPage\LandingPageEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<LandingPageEntity>
 */
#[Package('discovery')]
class LandingPageRouteResponse extends StoreApiResponse
{
    public function getLandingPage(): LandingPageEntity
    {
        return $this->object;
    }
}
