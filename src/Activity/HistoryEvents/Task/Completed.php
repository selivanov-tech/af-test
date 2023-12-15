<?php

namespace app\src\Activity\HistoryEvents\Task;

use app\models\Task;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\DTO\Interfaces\IEventWithBody;
use app\src\Activity\HistoryEvents\Task\Traits\CommonDataTrait;

/**
 * @property Task $eventModel
 */
class Completed extends AbstractEventData implements IEventWithBody
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'completed_task';
    }
}
