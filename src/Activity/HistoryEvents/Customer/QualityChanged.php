<?php

namespace app\src\Activity\HistoryEvents\Customer;

use app\models\Customer;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\Customer\Interfaces\IHaveChangedColumnValue;
use app\src\Activity\HistoryEvents\Customer\Traits\CommonDataTrait;

/**
 * @property Customer $eventModel
 */
class QualityChanged extends AbstractEventData implements IHaveChangedColumnValue
{
    use CommonDataTrait;

    public static function getEventName(): string
    {
        return 'customer_change_quality';
    }

    public static function getChangedColumnName(): string
    {
        return 'quality';
    }
}
