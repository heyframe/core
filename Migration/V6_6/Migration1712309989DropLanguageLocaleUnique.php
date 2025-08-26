<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1712309989DropLanguageLocaleUnique extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1712309989;
    }

    public function update(Connection $connection): void
    {
        $this->dropIndexIfExists($connection, 'language', 'uniq.translation_code_id');
    }
}
