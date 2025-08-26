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
class Migration1552360944MediaFolderConfigurationNoAssoc extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1552360944;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            ALTER TABLE `media_folder_configuration`
                ADD COLUMN `no_association` BOOL NULL AFTER `private`
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
