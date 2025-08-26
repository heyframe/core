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
class Migration1624884801MakeMailLinksConfigurable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1624884801;
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
            'configKey' => 'core.newsletter.subscribeUrl',
            'configValue' => '{"_value": "/newsletter-subscribe?em=%%HASHEDEMAIL%%&hash=%%SUBSCRIBEHASH%%"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $connection->executeStatement($query, [
            'id' => Uuid::randomBytes(),
            'configKey' => 'core.loginRegistration.pwdRecoverUrl',
            'configValue' => '{"_value": "/account/recover/password?hash=%%RECOVERHASH%%"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $connection->executeStatement($query, [
            'id' => Uuid::randomBytes(),
            'configKey' => 'core.loginRegistration.confirmationUrl',
            'configValue' => '{"_value": "/registration/confirm?em=%%HASHEDEMAIL%%&hash=%%SUBSCRIBEHASH%%"}',
            'createdAt' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
