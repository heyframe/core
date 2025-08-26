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
class Migration1586158920AddImportExportProfileConfig extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1586158920;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(
            'ALTER TABLE import_export_profile
            ADD COLUMN config JSON,
            ADD CONSTRAINT `json.import_export_profile.config` CHECK (JSON_VALID(`config`))'
        );
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
