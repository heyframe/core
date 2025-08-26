<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1620201616AddUpdatedAtToCart extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1620201616;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `cart` ADD COLUMN `updated_at` DATETIME(3) NULL;');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
