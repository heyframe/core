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
class Migration1610974673DropProductListingPriceTrigger extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1610974673;
    }

    public function update(Connection $connection): void
    {
        // implement update
    }

    public function updateDestructive(Connection $connection): void
    {
        try {
            $connection->executeStatement(
                'DROP TRIGGER `product_listing_price_update`'
            );
        } catch (\Throwable) {
        }
    }
}
