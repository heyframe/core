<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\Services;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\UsageData\Client\GatewayClient;
use Symfony\Component\HttpClient\Exception\ServerException;

/**
 * @internal
 */
#[Package('data-services')]
class GatewayStatusService
{
    public function __construct(
        private readonly GatewayClient $gatewayClient,
    ) {
    }

    public function isGatewayAllowsPush(): bool
    {
        try {
            return $this->gatewayClient->isGatewayAllowsPush();
        } catch (ServerException) {
            return false;
        }
    }
}
