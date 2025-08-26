<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Context;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @internal
 */
#[Package('framework')]
interface SalesChannelContextServiceInterface
{
    public function get(SalesChannelContextServiceParameters $parameters): SalesChannelContext;
}
