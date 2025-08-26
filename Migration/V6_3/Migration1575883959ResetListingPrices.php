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
class Migration1575883959ResetListingPrices extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1575883959;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('UPDATE product SET listing_prices = NULL');
        $this->registerIndexer($connection, 'Swag.ProductListingPriceIndexer');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
