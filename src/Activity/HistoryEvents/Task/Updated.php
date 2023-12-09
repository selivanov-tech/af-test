<?php

namespace app\src\Activity\HistoryEvents\Task;

use app\models\Task;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Task\Traits\CommonWidgetData;

/**
 * @property Task $eventModel
 */
class Updated extends AbstractEventData
{
    use CommonWidgetData;

    public const EVENT_NAME = 'updated_task';
}
