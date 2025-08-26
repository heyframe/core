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
class Migration1574672450RemoteAddressIntoCustomerAndOrderCustomerTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1574672450;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            ALTER TABLE `customer`
            ADD `remote_address` VARCHAR(255) NULL;
        ');

        $connection->executeStatement('
            ALTER TABLE `order_customer`
            ADD `remote_address` VARCHAR(255) NULL;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // nth
    }
}
