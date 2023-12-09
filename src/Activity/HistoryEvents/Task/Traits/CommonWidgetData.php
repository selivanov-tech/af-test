<?php

namespace app\src\Activity\HistoryEvents\Task\Traits;

use app\src\Activity\DTO\EventWidgetData;

trait CommonWidgetData
{
    public function getWidgetData(): EventWidgetData
    {
        $historyModel = $this->historyModel;
        $task = $this->eventModel;

        return new EventWidgetData(
            viewName: '_item_common',
            user: $historyModel->user,
            body: $this->getBody(),
            iconClass: 'fa-check-square bg-yellow',
            footerDatetime: new \DateTime($historyModel->ins_ts),
            footer: isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        );
    }

    public function getBody(): string
    {
        $taskModel = $this->eventModel;

        return sprintf('%s: %s', $this->historyModel->eventText, $taskModel->title);
    }
}
