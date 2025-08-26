<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Content\Media\DataAbstractionLayer\MediaFolderIndexer;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1652864153ReindexMediaFolders extends MigrationStep
{
    /**
     * @codeCoverageIgnore
     */
    public function getCreationTimestamp(): int
    {
        return 1652864153;
    }

    public function update(Connection $connection): void
    {
        if ($this->isInstallation()) {
            return;
        }

        $this->registerIndexer($connection, 'media_folder.indexer', [MediaFolderIndexer::CHILD_COUNT_UPDATER]);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
