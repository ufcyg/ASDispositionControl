<?php declare(strict_types=1);

namespace ASDispositionControl\ScheduledTask;

use ASDispositionControl\Core\Api\ASDispoControlController;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class DispoControlTaskHandler extends ScheduledTaskHandler
{    
    /** @var ASDispoControlController $dispoController */
    private $dispoController;
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository,
                                ASDispoControlController $dispoController)
    {
        $this->dispoController = $dispoController;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ DispoControlTask::class ];
    }

    public function run(): void
    {
        $this->dispoController->updateDispoControlData(Context::createDefaultContext());
        $this->dispoController->checkThresholds(Context::createDefaultContext());
    }    
}