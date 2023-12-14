<?php

namespace app\src\Activity\HistoryEvents\Sms;

use app\models\Sms;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\DTO\Interfaces\IEventWithBody;
use app\src\Activity\HistoryEvents\Sms\Traits\CommonDataTrait;

/**
 * @property Sms $eventModel
 */
class Outgoing extends AbstractEventData implements IEventWithBody
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'outgoing_sms';
    }
}
