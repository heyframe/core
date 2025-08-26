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
class Migration1610616655AddVisibleOnDetailToPropertyGroup extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1610616655;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            ALTER TABLE `property_group`
            ADD COLUMN `visible_on_product_detail_page` TINYINT(1) DEFAULT 1
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
