<?php

namespace app\src\Activity\HistoryEvents\Sms;

use app\models\Sms;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Sms\Traits\CommonDataTrait;

/**
 * @property Sms $eventModel
 */
class Incoming extends AbstractEventData
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'incoming_sms';
    }
}
