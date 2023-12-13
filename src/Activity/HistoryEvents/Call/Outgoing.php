<?php

namespace app\src\Activity\HistoryEvents\Call;

use app\models\Call;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Call\Traits\CommonDataTrait;

/**
 * @property Call $eventModel
 */
class Outgoing extends AbstractEventData
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'outgoing_call';
    }
}
