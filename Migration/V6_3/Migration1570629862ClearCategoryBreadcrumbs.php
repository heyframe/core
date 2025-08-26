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
class Migration1570629862ClearCategoryBreadcrumbs extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1570629862;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('UPDATE `category_translation` SET `breadcrumb` = NULL');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
