<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1747746986OrderTaxCalculationType extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1747746986;
    }

    public function update(Connection $connection): void
    {
        $this->addColumn($connection, 'order', 'tax_calculation_type', 'varchar(50)');
    }
}
