<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\ScheduledTask;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

/**
 * @internal
 */
#[Package('data-services')]
class CollectEntityDataTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'usage_data.entity_data.collect';
    }

    public static function getDefaultInterval(): int
    {
        return self::DAILY;
    }

    public static function shouldRescheduleOnFailure(): bool
    {
        return true;
    }
}
