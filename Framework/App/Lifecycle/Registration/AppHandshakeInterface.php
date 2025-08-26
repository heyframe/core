<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\App\Lifecycle\Registration;

use Psr\Http\Message\RequestInterface;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal only for use by the app-system
 */
#[Package('framework')]
interface AppHandshakeInterface
{
    public function assembleRequest(): RequestInterface;

    public function fetchAppProof(): string;
}
