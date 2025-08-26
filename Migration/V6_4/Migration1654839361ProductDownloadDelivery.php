<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\Migration\Traits\ImportTranslationsTrait;
use HeyFrame\Core\Migration\Traits\Translations;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1654839361ProductDownloadDelivery extends MigrationStep
{
    use ImportTranslationsTrait;

    final public const DELIVERY_TIME_NAME_EN = 'Instant download';
    final public const DELIVERY_TIME_NAME_DE = 'Sofort verfügbar';

    public function getCreationTimestamp(): int
    {
        return 1654839361;
    }

    public function update(Connection $connection): void
    {
        $downloadDeliveryTime = Uuid::randomBytes();

        $deliveryTimeTranslation = $connection->fetchOne(
            'SELECT LOWER(HEX(delivery_time_id)) FROM delivery_time_translation WHERE name = :deliveryTimeName',
            ['deliveryTimeName' => self::DELIVERY_TIME_NAME_EN]
        );

        if ($deliveryTimeTranslation) {
            return;
        }

        $connection->insert('delivery_time', [
            'id' => $downloadDeliveryTime,
            'min' => 0,
            'max' => 0,
            'unit' => 'hour',
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $translation = new Translations(
            [
                'delivery_time_id' => $downloadDeliveryTime,
                'name' => self::DELIVERY_TIME_NAME_DE,
            ],
            [
                'delivery_time_id' => $downloadDeliveryTime,
                'name' => self::DELIVERY_TIME_NAME_EN,
            ]
        );

        $this->importTranslation('delivery_time_translation', $translation, $connection);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
