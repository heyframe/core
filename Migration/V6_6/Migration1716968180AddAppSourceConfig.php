<?php

declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1716968180AddAppSourceConfig extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1716968180;
    }

    public function update(Connection $connection): void
    {
        $this->addColumn($connection, 'app', 'source_config', 'JSON', false, '(JSON_OBJECT())');
    }
}
