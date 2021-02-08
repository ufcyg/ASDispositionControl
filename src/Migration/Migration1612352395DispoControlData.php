<?php declare(strict_types=1);

namespace ASDispositionControl\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1612352395DispoControlData extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1612352395;
    }

    public function update(Connection $connection): void
    {
        $connection->exec("CREATE TABLE IF NOT EXISTS `as_dispo_control_data` (
            `id`            BINARY(16) NOT NULL,
            `notifications_activated`    BOOLEAN NOT NULL,
            `product_id`    VARCHAR(255) NOT NULL,
            `product_name`    VARCHAR(255) NOT NULL,
            `product_number`    VARCHAR(255) NOT NULL,
            `stock`    INTEGER NOT NULL,
            `commissioned`    INTEGER NOT NULL,
            `stock_available`    INTEGER NOT NULL,
            `incoming`    INTEGER NOT NULL,
            `minimum_threshold`    INTEGER NOT NULL,
            `notification_threshold`    INTEGER NOT NULL,
            `created_at`    DATETIME(3),
            `updated_at`    DATETIME(3)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
