<?php declare(strict_types=1);

namespace ASDispositionControl\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class DispoControlNotificationTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'as.dispo_control_notification_task';
    }

    public static function getDefaultInterval(): int
    {
        return 86340; // 24 hours
    }
}