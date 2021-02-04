<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class DispoControlDataDefinition extends EntityDefinition
{

    public function getEntityName(): string
    {
        return 'as_dispo_control_data';
    }

    public function getCollectionClass(): string
    {
        return DispoControlDataCollection::class;
    }

    public function getEntityClass(): string
    {
        return DispoControlDataEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection(
            [
                (new IdField('id','id'))->addFlags(new Required(), new PrimaryKey()),
                new StringField('product_id','productId'),
                new IntField('outgoing','outgoing'),
                new IntField('incoming','incoming'),
                new IntField('minimum_threshold','minimumThreshold'),
                new IntField('notification_threshold','notificationThreshold')
            ]
        );
    }
}
// $connection->exec("CREATE TABLE IF NOT EXISTS `as_dispo_control_data` (
//     `id`            BINARY(16) NOT NULL,
//     `product_id`    VARCHAR(255) NOT NULL,
//     `outgoing`    INTEGER NOT NULL,
//     `incoming`    INTEGER NOT NULL,
//     `minimum_threshold`    INTEGER NOT NULL,
//     `notification_threshold`    INTEGER NOT NULL,
//     `created_at`    DATETIME(3),
//     `updated_at`    DATETIME(3)
//     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");