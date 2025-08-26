<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_5;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1659425718AddFlagsToCustomEntities extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1659425718;
    }

    public function update(Connection $connection): void
    {
        $this->addColumn(
            connection: $connection,
            table: 'custom_entity',
            column: 'flags',
            type: 'JSON'
        );
    }
}
