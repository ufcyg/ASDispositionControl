<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class DispoControlDataEntity extends Entity
{
    use EntityIdTrait;
    
    /** @var string */
    protected $productId;
    /** @var int */
    protected $outgoing;
    /** @var int */
    protected $incoming;
    /** @var int */
    protected $minimumThreshold;
    /** @var int */
    protected $notificationThreshold;


    /** Get the value of productId */ 
    public function getProductId()
    {
        return $this->productId;
    }

    /** Set the value of productId  @return  self */ 
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /** Get the value of outgoing */ 
    public function getOutgoing()
    {
        return $this->outgoing;
    }

    /** Set the value of outgoing @return  self */ 
    public function setOutgoing($outgoing)
    {
        $this->outgoing = $outgoing;

        return $this;
    }

    /** Get the value of incoming */ 
    public function getIncoming()
    {
        return $this->incoming;
    }

    /** Set the value of incoming @return  self */ 
    public function setIncoming($incoming)
    {
        $this->incoming = $incoming;

        return $this;
    }

    /** Get the value of minimumThreshold */ 
    public function getMinimumThreshold()
    {
        return $this->minimumThreshold;
    }

    /** Set the value of minimumThreshold @return  self */ 
    public function setMinimumThreshold($minimumThreshold)
    {
        $this->minimumThreshold = $minimumThreshold;

        return $this;
    }

    /** Get the value of notificationThreshold */ 
    public function getNotificationThreshold()
    {
        return $this->notificationThreshold;
    }

    /** Set the value of notificationThreshold @return  self */ 
    public function setNotificationThreshold($notificationThreshold)
    {
        $this->notificationThreshold = $notificationThreshold;

        return $this;
    }
}