<?php

namespace app\src\Activity\HistoryEvents\Task\Traits;

use app\src\Activity\DTO\CommonEventWidgetData;
use DateTime;

trait CommonDataTrait
{
    public function getWidgetData(): CommonEventWidgetData
    {
        $historyModel = $this->historyModel;
        $task = $this->eventModel;

        return new CommonEventWidgetData(
            viewName: '_item_common',
            user: $historyModel->user,
            body: $this->getBody(),
            iconClass: 'fa-check-square bg-yellow',
            footerDatetime: new DateTime($historyModel->ins_ts),
            footer: isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        );
    }

    public function getBody(): string
    {
        $taskModel = $this->eventModel;

        return sprintf('%s: %s', $this->historyModel->eventText, $taskModel->title);
    }
}
