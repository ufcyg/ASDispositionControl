<?php

declare(strict_types=1);

namespace ASDispositionControl\Core\Content\DispoControlData;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class DispoControlDataEntity extends Entity
{
    use EntityIdTrait;

    /** @var bool */
    protected $notificationsActivated;
    /** @var string */
    protected $productId;
    /** @var string */
    protected $productName;
    /** @var string */
    protected $productNumber;
    /** @var int */
    protected $stock;
    /** @var int */
    protected $commissioned;
    /** @var int */
    protected $stockAvailable;
    /** @var int */
    protected $incoming;
    /** @var int */
    protected $minimumThreshold;
    /** @var int */
    protected $notificationThreshold;


    /** Get the value of notificationsActivated */
    public function getNotificationsActivated()
    {
        return $this->notificationsActivated;
    }

    /** Set the value of notificationsActivated @return  self */
    public function setNotificationsActivated($notificationsActivated)
    {
        $this->notificationsActivated = $notificationsActivated;

        return $this;
    }

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

    /** Get the value of productName */
    public function getProductName()
    {
        return $this->productName;
    }

    /** Set the value of productName @return  self */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /** Get the value of productNumber */
    public function getProductNumber()
    {
        return $this->productNumber;
    }

    /** Set the value of productNumber @return  self */
    public function setProductNumber($productNumber)
    {
        $this->productNumber = $productNumber;

        return $this;
    }

    /** Get the value of stock */
    public function getStock()
    {
        return $this->stock;
    }

    /** Set the value of stock @return  self */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /** Get the value of commissioned */
    public function getCommissioned()
    {
        return $this->commissioned;
    }

    /** Set the value of commissioned @return  self */
    public function setCommissioned($commissioned)
    {
        $this->commissioned = $commissioned;

        return $this;
    }

    /** Get the value of stockAvailable */
    public function getStockAvailable()
    {
        return $this->stockAvailable;
    }

    /** Set the value of stockAvailable @return  self */
    public function setStockAvailable($stockAvailable)
    {
        $this->stockAvailable = $stockAvailable;

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
