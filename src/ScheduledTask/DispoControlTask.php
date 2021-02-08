<?php declare(strict_types=1);

namespace ASDispositionControl\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class DispoControlTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'as.dispo_control_task';
    }

    public static function getDefaultInterval(): int
    {
        return 86400; // 24 hours
    }
}