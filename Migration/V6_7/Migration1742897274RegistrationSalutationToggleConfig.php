<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_7;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
#[Package('framework')]
class Migration1742897274RegistrationSalutationToggleConfig extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1742897274;
    }

    public function update(Connection $connection): void
    {
        $config = $connection->fetchAllAssociativeIndexed(
            'SELECT `configuration_value` FROM `system_config` WHERE `configuration_key` = ? and `sales_channel_id` is null',
            ['core.loginRegistration.showSalutation']
        );

        if (!empty($config)) {
            return;
        }

        $connection->insert('system_config', [
            'id' => Uuid::randomBytes(),
            'configuration_key' => 'core.loginRegistration.showSalutation',
            'configuration_value' => json_encode(['_value' => true]),
            'sales_channel_id' => null,
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }
}
