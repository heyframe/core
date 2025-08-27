<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_3;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;
use HeyFrame\Core\Framework\Uuid\Uuid;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('framework')]
class Migration1575021466AddCurrencies extends MigrationStep
{
    private ?string $zhLanguage = null;

    private ?string $defaultLanguage = null;

    public function getCreationTimestamp(): int
    {
        return 1575021466;
    }

    public function update(Connection $connection): void
    {
        $this->createCurrencyUniqueConstraint($connection);
        $this->createCurrencies($connection);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }

    private function createCurrencyUniqueConstraint(Connection $connection): void
    {
        $connection->executeStatement('ALTER TABLE `currency` ADD  CONSTRAINT `uniq.currency.iso_code` UNIQUE (`iso_code`)');
    }

    private function createCurrencies(Connection $connection): void
    {
        $this->addCurrency($connection, Uuid::randomBytes(), 'PLN', 0.5144, 'zł', 'PLN', 'PLN', '波兰兹罗提', 'Złoty');
        $this->addCurrency($connection, Uuid::randomBytes(), 'CHF', 0.1127, 'Fr', 'CHF', 'CHF', '瑞士法郎', 'Swiss francs');
        $this->addCurrency($connection, Uuid::randomBytes(), 'SEK', 1.3395, 'kr', 'SEK', 'SEK', '瑞典克朗', 'Swedish krone');
        $this->addCurrency($connection, Uuid::randomBytes(), 'DKK', 0.8993, 'kr', 'DKK', 'DKK', '丹麦克朗', 'Danish krone');
        $this->addCurrency($connection, Uuid::randomBytes(), 'NOK', 1.421, 'nkr', 'NOK', 'NOK', '挪威克朗', 'Norwegian krone');
    }

    private function addCurrency(
        Connection $connection,
        string $id,
        string $isoCode,
        float $factor,
        string $symbol,
        string $shortNameZh,
        string $shortNameEn,
        string $nameZh,
        string $nameEn
    ): void {
        $languageEN = $this->getEnLanguageId($connection);
        $languageDE = $this->getZhLanguageId($connection);

        $langId = $connection->fetchOne('
        SELECT `currency`.`id` FROM `currency` WHERE `iso_code` = :code LIMIT 1
        ', ['code' => $isoCode]);

        if (!$langId) {
            $connection->insert('currency', ['id' => $id, 'iso_code' => $isoCode, 'factor' => $factor, 'symbol' => $symbol, 'position' => 1, 'decimal_precision' => 2, 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
            if ($languageEN !== $languageDE) {
                $connection->insert('currency_translation', ['currency_id' => $id, 'language_id' => $languageEN, 'short_name' => $shortNameEn, 'name' => $nameEn, 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
            }

            if ($languageDE) {
                $connection->insert('currency_translation', ['currency_id' => $id, 'language_id' => $languageDE, 'short_name' => $shortNameZh, 'name' => $nameZh, 'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)]);
            }
        }
    }

    private function getZhLanguageId(Connection $connection): ?string
    {
        if (!$this->zhLanguage) {
            $this->zhLanguage = $this->fetchLanguageId('zh-CN', $connection);
        }

        return $this->zhLanguage;
    }

    private function getEnLanguageId(Connection $connection): ?string
    {
        if (!$this->defaultLanguage) {
            $this->defaultLanguage = $this->fetchLanguageId('en-GB', $connection);
        }

        return $this->defaultLanguage;
    }

    private function fetchLanguageId(string $code, Connection $connection): ?string
    {
        $langId = $connection->fetchOne('
        SELECT `language`.`id` FROM `language` INNER JOIN `locale` ON `language`.`translation_code_id` = `locale`.`id` WHERE `code` = :code LIMIT 1
        ', ['code' => $code]);

        if (!$langId && $code !== 'en-GB') {
            return null;
        }

        if (!$langId) {
            return Uuid::fromHexToBytes(Defaults::LANGUAGE_SYSTEM);
        }

        return $langId;
    }
}
