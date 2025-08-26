<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\Consent;

use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal
 */
#[Package('data-services')]
enum ConsentState: string
{
    case REQUESTED = 'requested';
    case ACCEPTED = 'accepted';
    case REVOKED = 'revoked';
}
