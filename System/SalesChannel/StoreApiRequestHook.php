<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Facade\RepositoryFacadeHookFactory;
use HeyFrame\Core\Framework\DataAbstractionLayer\Facade\SalesChannelRepositoryFacadeHookFactory;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Script\Execution\Awareness\SalesChannelContextAware;
use HeyFrame\Core\Framework\Script\Execution\Hook;
use HeyFrame\Core\System\SystemConfig\Facade\SystemConfigFacadeHookFactory;

/**
 * @internal only rely on the concrete implementations
 */
#[Package('framework')]
abstract class StoreApiRequestHook extends Hook implements SalesChannelContextAware
{
    /**
     * @return string[]
     */
    public static function getServiceIds(): array
    {
        return [
            RepositoryFacadeHookFactory::class,
            SystemConfigFacadeHookFactory::class,
            SalesChannelRepositoryFacadeHookFactory::class,
        ];
    }
}
