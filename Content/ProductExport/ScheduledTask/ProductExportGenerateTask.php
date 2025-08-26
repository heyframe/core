<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\ScheduledTask;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

#[Package('inventory')]
class ProductExportGenerateTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'product_export_generate_task';
    }

    public static function getDefaultInterval(): int
    {
        return 60;
    }

    public static function shouldRescheduleOnFailure(): bool
    {
        return true;
    }
}
