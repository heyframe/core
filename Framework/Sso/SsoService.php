<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Sso;

use HeyFrame\Administration\Login\Config\LoginConfig;
use HeyFrame\Administration\Login\Config\LoginConfigService;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal
 */
#[Package('framework')]
class SsoService
{
    public function __construct(
        private readonly LoginConfigService $loginConfigService,
    ) {
    }

    public function isSso(): bool
    {
        return $this->loginConfigService->getConfig() instanceof LoginConfig;
    }
}
