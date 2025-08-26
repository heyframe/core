<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_3;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1566293076AddAutoIncrement extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1566293076;
    }

    public function update(Connection $connection): void
    {
    }

    public function updateDestructive(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `product` ADD `auto_increment` int(11) NOT NULL AUTO_INCREMENT UNIQUE AFTER `version_id`;');
        $connection->executeStatement('ALTER TABLE `category` ADD `auto_increment` int(11) NOT NULL AUTO_INCREMENT UNIQUE AFTER `version_id`;');
    }
}
