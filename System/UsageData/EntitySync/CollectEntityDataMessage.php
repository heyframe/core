<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\EntitySync;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\LowPriorityMessageInterface;

/**
 * @internal
 */
#[Package('data-services')]
class CollectEntityDataMessage implements LowPriorityMessageInterface
{
    public function __construct(public readonly ?string $shopId = null)
    {
    }
}
