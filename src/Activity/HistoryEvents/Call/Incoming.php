<?php

namespace app\src\Activity\HistoryEvents\Call;

use app\models\Call;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Call\Traits\CommonDataTrait;

/**
 * @property Call $eventModel
 */
class Incoming extends AbstractEventData
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'incoming_call';
    }
}