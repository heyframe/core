<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\InheritanceUpdaterTrait;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1610523204AddInheritanceForProductCmsPage extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public function getCreationTimestamp(): int
    {
        return 1610523204;
    }

    public function update(Connection $connection): void
    {
        $this->updateInheritance($connection, 'product', 'cmsPage');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
