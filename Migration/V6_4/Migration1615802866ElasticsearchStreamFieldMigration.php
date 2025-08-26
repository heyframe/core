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
class Migration1615802866ElasticsearchStreamFieldMigration extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1615802866;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('UPDATE product_stream_filter SET field = "categoriesRo.id" WHERE field = "categories.id"');
        $connection->executeStatement('UPDATE product_stream_filter SET field = "manufacturerId" WHERE field = "manufacturer.id"');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
