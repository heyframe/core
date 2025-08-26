<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\UsageData\UsageDataException;

/**
 * @internal
 */
#[Package('data-services')]
class ConsentAlreadyAcceptedException extends UsageDataException
{
}
