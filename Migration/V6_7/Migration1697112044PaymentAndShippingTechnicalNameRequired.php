<?php declare(strict_types=1);

namespace HeyFrame\Core\Migration\V6_7;

use Doctrine\DBAL\Connection;
use HeyFrame\Core\Checkout\Payment\PaymentMethodDefinition;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('checkout')]
class Migration1697112044PaymentAndShippingTechnicalNameRequired extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1697112044;
    }

    public function update(Connection $connection): void
    {
        $manager = $connection->createSchemaManager();
        $columns = $manager->listTableColumns(PaymentMethodDefinition::ENTITY_NAME);

        if (\array_key_exists('technical_name', $columns) && !$columns['technical_name']->getNotnull()) {
            $connection->executeStatement('ALTER TABLE `payment_method` MODIFY COLUMN `technical_name` VARCHAR(255) NOT NULL');
        }

        $columns = $manager->listTableColumns('shipping_method');

        if (\array_key_exists('technical_name', $columns) && !$columns['technical_name']->getNotnull()) {
            $connection->executeStatement('ALTER TABLE `shipping_method` MODIFY COLUMN `technical_name` VARCHAR(255) NOT NULL');
        }
    }
}
