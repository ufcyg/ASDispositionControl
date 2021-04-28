<?php

declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
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
                (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
                new BoolField('notifications_activated', 'notificationsActivated'),
                new StringField('product_id', 'productId'),
                new StringField('product_name', 'productName'),
                new StringField('product_number', 'productNumber'),
                new IntField('stock', 'stock'),
                new IntField('commissioned', 'commissioned'),
                new IntField('stock_available', 'stockAvailable'),
                new IntField('incoming', 'incoming'),
                new IntField('minimum_threshold', 'minimumThreshold'),
                new IntField('notification_threshold', 'notificationThreshold')
            ]
        );
    }
}
