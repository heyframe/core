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
class Migration1627562945AddImportExportPromotionCodesProfile extends MigrationStep
{
    use ImportTranslationsTrait;

    public function getCreationTimestamp(): int
    {
        return 1627562945;
    }

    public function update(Connection $connection): void
    {
        $id = Uuid::randomBytes();

        $connection->insert('import_export_profile', [
            'id' => $id,
            'name' => 'Default promotion codes',
            'system_default' => 1,
            'source_entity' => 'promotion_individual_code',
            'file_type' => 'text/csv',
            'delimiter' => ';',
            'enclosure' => '"',
            'mapping' => json_encode([
                ['key' => 'id', 'mappedKey' => 'id'],
                ['key' => 'promotion.id', 'mappedKey' => 'promotion_id'],
                ['key' => 'promotion.translations.DEFAULT.name', 'mappedKey' => 'promotion_name'],
                ['key' => 'code', 'mappedKey' => 'code'],
            ]),
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $translations = new Translations(
            [
                'import_export_profile_id' => $id,
                'label' => 'Standardprofil Aktionscodes',
            ],
            [
                'import_export_profile_id' => $id,
                'label' => 'Default promotion codes',
            ]
        );

        $this->importTranslation('import_export_profile_translation', $translations, $connection);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
