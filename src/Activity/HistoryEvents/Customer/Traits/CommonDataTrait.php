<?php

namespace app\src\Activity\HistoryEvents\Customer\Traits;

use app\models\Customer;
use app\src\Activity\DTO\OldNewEventWidgetData;

trait CommonDataTrait
{
    public function getWidgetData(): OldNewEventWidgetData
    {
        $historyModel = $this->historyModel;

        $changedColumn = self::getChangedColumnName();

        return new OldNewEventWidgetData(
            viewName: '_item_statuses_change',
            model: $historyModel,
            oldValue: Customer::getTypeTextByType($historyModel->getDetailOldValue($changedColumn)),
            newValue: Customer::getTypeTextByType($historyModel->getDetailNewValue($changedColumn)),
        );
    }
}
