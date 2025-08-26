<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_7;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
#[Package('inventory')]
class Migration1745319883AddDefaultConfigForMeasurementSystem extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1745319883;
    }

    public function update(Connection $connection): void
    {
        $query = 'INSERT IGNORE INTO system_config SET
                    id = :id,
                    configuration_value = :configValue,
                    configuration_key = :configKey,
                    created_at = :createdAt;';

        $connection->executeStatement($query, [
            'id' => Uuid::randomBytes(),
            'configKey' => 'core.measurementUnits.system',
            'configValue' => '{"_value": "metric"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $connection->executeStatement($query, [
            'id' => Uuid::randomBytes(),
            'configKey' => 'core.measurementUnits.length',
            'configValue' => '{"_value": "mm"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $connection->executeStatement($query, [
            'id' => Uuid::randomBytes(),
            'configKey' => 'core.measurementUnits.weight',
            'configValue' => '{"_value": "kg"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }
}
