<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskDefinition;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1667983492UpdateQueuedTasksToSkipped extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1667983492;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(
            'UPDATE `scheduled_task` SET `status` = :skippedStatus, next_execution_time = :nextExecutionTime
                WHERE `status` = :queuedStatus AND `name` IN (:skippedTasks)',
            [
                'skippedStatus' => ScheduledTaskDefinition::STATUS_SKIPPED,
                'queuedStatus' => ScheduledTaskDefinition::STATUS_QUEUED,
                'skippedTasks' => ['heyframe.invalidate_cache', 'heyframe.elasticsearch.create.alias'],
                'nextExecutionTime' => (new \DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
            ],
            [
                'skippedTasks' => ArrayParameterType::STRING,
            ]
        );
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
