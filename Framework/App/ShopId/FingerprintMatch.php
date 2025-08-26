<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\App\ShopId;

use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
readonly class FingerprintMatch
{
    public function __construct(
        public string $identifier,
        public string $stamp,
    ) {
    }
}
