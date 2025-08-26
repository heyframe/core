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
class Migration1612865237AddCheapestPrice extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1612865237;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `product` ADD `cheapest_price` longtext NULL;');
        $connection->executeStatement('ALTER TABLE `product` ADD `cheapest_price_accessor` longtext NULL;');
    }

    public function updateDestructive(Connection $connection): void
    {
        // nth
    }
}
