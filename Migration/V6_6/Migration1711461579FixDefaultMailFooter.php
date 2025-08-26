<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\Migration\Traits\ImportTranslationsTrait;

/**
 * @internal
 */
#[Package('framework')]
class Migration1711461579FixDefaultMailFooter extends MigrationStep
{
    use ImportTranslationsTrait;

    public function getCreationTimestamp(): int
    {
        return 1711461579;
    }

    public function update(Connection $connection): void
    {
        $languages = $this->getLanguageIds($connection, 'de-DE');
        if (!$languages) {
            return;
        }

        $connection->executeStatement(
            'UPDATE mail_header_footer_translation
            SET footer_plain = REPLACE(footer_plain, \'Addresse:\', \'Adresse:\')
            WHERE language_id IN (:ids)',
            ['ids' => Uuid::fromHexToBytesList($languages)],
            ['ids' => ArrayParameterType::BINARY]
        );
    }
}
