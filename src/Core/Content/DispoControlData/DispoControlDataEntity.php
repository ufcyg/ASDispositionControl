<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class DispoControlDataEntity extends Entity
{
    use EntityIdTrait;
    
    /** @var string */
    protected $orderId;
}