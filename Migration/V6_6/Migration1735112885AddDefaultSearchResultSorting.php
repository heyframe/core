<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
#[Package('framework')]
class Migration1735112885AddDefaultSearchResultSorting extends MigrationStep
{
    private const CONFIG_KEY = 'core.listing.defaultSearchResultSorting';

    public function getCreationTimestamp(): int
    {
        return 1735112885;
    }

    public function update(Connection $connection): void
    {
        $configPresent = $connection->fetchOne('SELECT 1 FROM `system_config` WHERE `configuration_key` = ?', [self::CONFIG_KEY]);

        if ($configPresent !== false) {
            return;
        }

        $productSortingId = $connection->fetchOne('SELECT id FROM `product_sorting` WHERE `url_key` = ?', ['score']);
        $connection->insert('system_config', [
            'id' => Uuid::randomBytes(),
            'configuration_key' => self::CONFIG_KEY,
            'configuration_value' => \sprintf('{"_value": "%s"}', Uuid::fromBytesToHex($productSortingId)),
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }
}
