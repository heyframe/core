<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1716285861AddAppSourceType extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1716285861;
    }

    public function update(Connection $connection): void
    {
        $this->addColumn($connection, 'app', 'source_type', 'VARCHAR(20)', false, '\'local\'');
    }
}
