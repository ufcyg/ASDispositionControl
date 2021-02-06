<?php declare(strict_types=1);

namespace ASDispositionControl\ScheduledTask;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class DispoControlTaskHandler extends ScheduledTaskHandler
{    
    public function __construct(EntityRepositoryInterface $scheduledTaskRepository)
    {
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ DispoControlTask::class ];
    }

    public function run(): void
    {
        // $path = '../custom/plugins/ASDispositionControl/TestFolderScheduledTask/';

        // if (!file_exists($path)) {
        //     mkdir($path, 0777, true);
        // }
    }    
}