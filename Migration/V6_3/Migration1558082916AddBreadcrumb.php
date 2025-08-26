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
class Migration1558082916AddBreadcrumb extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1558082916;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `category_translation` ADD `breadcrumb` json NULL AFTER `name`;');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
