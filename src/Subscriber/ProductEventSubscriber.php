<?php declare(strict_types=1);

namespace ASDispositionControl\Subscriber;

use ASDispositionControl\Core\Api\ASDispoControlController;
use Shopware\Core\Content\Product\ProductEvents;
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

    public function __construct(SystemConfigService $systemConfigService,
                                ASDispoControlController $asDispoController)
    {
        $this->systemConfigService = $systemConfigService;
        $this->asDispoController = $asDispoController;
    }
    public static function getSubscribedEvents(): array
    {
        // Return the events to listen to as array like this:  <event to listen to> => <method to execute>
        return [
            'product.written' => 'onProductWrittenEvent',
            'product.deleted' => 'onProductDeletedEvent'
        ];
    }

    public function onProductWrittenEvent(EntityWrittenEvent $event)
    {
        $this->asDispoController->updateDispoControlData(Context::createDefaultContext());
    }

    public function onProductDeletedEvent(EntityWrittenEvent $event)
    {
        $eventArray = $event->getWriteResults();
        $this->asDispoController->deleteDispoControlEntry($eventArray[0]->getPrimaryKey(),Context::createDefaultContext());
    }
}