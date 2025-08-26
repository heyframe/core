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
class Migration1630074081AddDeleteCascadeToImportExportLogTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1630074081;
    }

    public function update(Connection $connection): void
    {
        $this->dropForeignKeyIfExists($connection, 'import_export_log', 'fk.import_export_log.file_id');
        $connection->executeStatement('ALTER TABLE `import_export_log` ADD CONSTRAINT `fk.import_export_log.file_id` FOREIGN KEY (`file_id`) REFERENCES `import_export_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }
}
