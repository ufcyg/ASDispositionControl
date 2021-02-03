<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class DispoControlDataDefinition extends EntityDefinition
{

    public function getEntityName(): string
    {
        return 'as_cancelled_confirmation';
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
                // (new IdField('id','id'))->addFlags(new Required(), new PrimaryKey()),
                // new StringField('order_id','orderId')
            ]
        );
    }
}