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
class Migration1647260673AddIndexForEmail extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1647260673;
    }

    public function update(Connection $connection): void
    {
        $keys = \array_column($connection->fetchAllAssociative('SHOW INDEX FROM customer'), 'Key_name');

        if (\in_array('idx.email', $keys, true)) {
            return;
        }

        $connection->executeStatement('CREATE INDEX `idx.email` ON `customer` (`email`)');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
