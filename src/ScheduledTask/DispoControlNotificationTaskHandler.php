<?php declare(strict_types=1);

namespace ASDispositionControl\ScheduledTask;

use ASDispositionControl\Core\Api\ASDispoControlController;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class DispoControlNotificationTaskHandler extends ScheduledTaskHandler
{    
    /** @var ASDispoControlController $asDispoController */
    private $asDispoController;
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                ASDispoControlController $asDispoController)
    {
        $this->asDispoController = $asDispoController;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ DispoControlNotificationTask::class ];
    }

    public function run(): void
    {
        $this->asDispoController->checkThresholds(Context::createDefaultContext());
    }    
}