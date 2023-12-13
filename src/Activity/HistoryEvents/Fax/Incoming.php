<?php

namespace app\src\Activity\HistoryEvents\Fax;

use app\models\Fax;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Fax\Traits\CommonDataTrait;

/**
 * @property Fax $eventModel
 */
class Incoming extends AbstractEventData
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'incoming_fax';
    }
}
