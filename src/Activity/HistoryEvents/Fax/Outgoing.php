<?php

namespace app\src\Activity\HistoryEvents\Fax;

use app\models\Fax;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\DTO\Interfaces\IEventWithBody;
use app\src\Activity\HistoryEvents\Fax\Traits\CommonDataTrait;

/**
 * @property Fax $eventModel
 */
class Outgoing extends AbstractEventData implements IEventWithBody
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'outgoing_fax';
    }
}
