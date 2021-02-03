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
        // implement update
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
