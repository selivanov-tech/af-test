<?php

namespace app\src\Activity\HistoryEvents\Sms;

use app\models\Sms;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Sms\Traits\CommonWidgetData;

/**
 * @property Sms $eventModel
 */
class Outgoing extends AbstractEventData
{
    use CommonWidgetData;

    public const EVENT_NAME = 'outgoing_sms';
}
