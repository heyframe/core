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
class Migration1580819350AddTrackingUrl extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1580819350;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `shipping_method_translation` ADD `tracking_url` MEDIUMTEXT NULL DEFAULT NULL AFTER `description`;');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
