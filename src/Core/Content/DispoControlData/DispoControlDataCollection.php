<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(DispoControlDataCollection $entity)
 * @method void              set(string $key, DispoControlDataCollection $entity)
 * @method DispoControlDataCollection[]    getIterator()
 * @method DispoControlDataCollection[]    getElements()
 * @method DispoControlDataCollection|null get(string $key)
 * @method DispoControlDataCollection|null first()
 * @method DispoControlDataCollection|null last()
 */
class DispoControlDataCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return DispoControlDataEntity::class;
    }
}