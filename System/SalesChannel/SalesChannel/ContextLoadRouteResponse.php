<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<SalesChannelContext>
 */
#[Package('framework')]
class ContextLoadRouteResponse extends StoreApiResponse
{
    public function getContext(): SalesChannelContext
    {
        return $this->object;
    }
}
