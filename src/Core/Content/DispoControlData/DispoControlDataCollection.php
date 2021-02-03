<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(SteeredCustomerRegistrationCollection $entity)
 * @method void              set(string $key, SteeredCustomerRegistrationCollection $entity)
 * @method SteeredCustomerRegistrationCollection[]    getIterator()
 * @method SteeredCustomerRegistrationCollection[]    getElements()
 * @method SteeredCustomerRegistrationCollection|null get(string $key)
 * @method SteeredCustomerRegistrationCollection|null first()
 * @method SteeredCustomerRegistrationCollection|null last()
 */
class DispoControlDataCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return DispoControlDataEntity::class;
    }
}