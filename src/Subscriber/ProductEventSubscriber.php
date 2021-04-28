<?php

declare(strict_types=1);

namespace ASDispositionControl\Subscriber;

use ASDispositionControl\Core\Api\ASDispoControlController;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductEventSubscriber implements EventSubscriberInterface
{
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    /** @var ASDispoControlController $asDispoController */
    private $asDispoController;

    public function __construct(
        SystemConfigService $systemConfigService,
        ASDispoControlController $asDispoController
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->asDispoController = $asDispoController;
    }
    public static function getSubscribedEvents(): array
    {
        // Return the events to listen to as array like this:  <event to listen to> => <method to execute>
        return [
            'product.written' => 'onProductWrittenEvent',
            'product.deleted' => 'onProductDeletedEvent',
            'order.written' => 'onOrderWrittenEvent'
        ];
    }

    public function onProductWrittenEvent(EntityWrittenEvent $event)
    {
        $eventArray = $event->getWriteResults();
        $this->asDispoController->upsertDispoControlEntry($eventArray[0]->getPrimaryKey(), Context::createDefaultContext());
    }

    public function onOrderWrittenEvent(EntityWrittenEvent $event)
    {
        // $this->asDispoController->initDispoControlData(Context::createDefaultContext());

        // $eventArray = $event->getWriteResults();
        // $orderID = $eventArray[0]->getPrimaryKey();
        // $payload = $eventArray[0]->getPayload();
        // if(array_key_exists('stateId', $payload))
        // {
        //     $newStateID = $payload['stateId'];
        //     $this->asDispoController->updateOrderStatusChange($orderID,$newStateID);
        //     $this->asDispoController->checkThresholds(Context::createDefaultContext());
        // }
    }

    public function onProductDeletedEvent(EntityWrittenEvent $event)
    {
        $eventArray = $event->getWriteResults();
        $this->asDispoController->deleteDispoControlEntry($eventArray[0]->getPrimaryKey(), Context::createDefaultContext());
    }
}
