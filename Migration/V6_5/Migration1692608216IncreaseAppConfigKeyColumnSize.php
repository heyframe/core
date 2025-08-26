<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_5;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1692608216IncreaseAppConfigKeyColumnSize extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1692608216;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            ALTER TABLE `app_config`
            MODIFY COLUMN `key` VARCHAR(255);
        ');
    }
}
