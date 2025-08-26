<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_5;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
class Migration1674200008UpdateOrderViewerRolePrivileges extends MigrationStep
{
    final public const NEW_PRIVILEGES = [
        'order.viewer' => [
            'media_default_folder:read',
        ],
    ];

    public function getCreationTimestamp(): int
    {
        return 1674200008;
    }

    public function update(Connection $connection): void
    {
        $this->addAdditionalPrivileges($connection, self::NEW_PRIVILEGES);
    }
}
