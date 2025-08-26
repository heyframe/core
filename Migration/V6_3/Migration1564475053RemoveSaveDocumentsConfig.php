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
class Migration1564475053RemoveSaveDocumentsConfig extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1564475053;
    }

    public function update(Connection $connection): void
    {
        $connection->delete('system_config', [
            'configuration_key' => 'core.saveDocuments',
        ]);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
