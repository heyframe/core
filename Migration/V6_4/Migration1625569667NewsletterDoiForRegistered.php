<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1625569667NewsletterDoiForRegistered extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1625569667;
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
            'configKey' => 'core.newsletter.doubleOptInRegistered',
            'configValue' => '{"_value": false}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
