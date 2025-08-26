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
class Migration1631703921MigrateLineItemsInCartRule extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1631703921;
    }

    public function update(Connection $connection): void
    {
        // moved to V6_5/Migration1669291632MigrateLineItemsInCartRule.php
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
