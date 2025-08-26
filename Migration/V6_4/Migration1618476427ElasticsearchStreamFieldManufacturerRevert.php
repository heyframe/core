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
class Migration1618476427ElasticsearchStreamFieldManufacturerRevert extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1618476427;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('UPDATE product_stream_filter SET field = "manufacturer.id" WHERE field = "manufacturerId"');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
