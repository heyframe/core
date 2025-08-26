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
class Migration1601891339EventActionTitle extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1601891339;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `event_action` ADD `title` varchar(500) NULL AFTER `id`;');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
