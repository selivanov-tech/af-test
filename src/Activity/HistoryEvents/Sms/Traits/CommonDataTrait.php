<?php

namespace app\src\Activity\HistoryEvents\Sms\Traits;

use app\src\Activity\DTO\CommonEventWidgetData;
use app\src\Activity\HistoryEvents\Sms\Incoming;
use app\src\Activity\HistoryEvents\Sms\Outgoing;
use DateTime;
use LogicException;
use Yii;

trait CommonDataTrait
{
    public function getWidgetData(): CommonEventWidgetData
    {
        $historyModel = $this->historyModel;

        return new CommonEventWidgetData(
            viewName: '_item_common',
            user: $historyModel->user,
            body: $this->getBody(),
            iconClass: 'icon-sms bg-dark-blue',
            // todo: implement? not used anywhere
            // iconIncome: $this->eventModel->direction == Sms::DIRECTION_INCOMING,
            footerDatetime: new DateTime($historyModel->ins_ts),
            footer: $this->getFooter()
        );
    }

    public function getBody(): string
    {
        return $this->eventModel->message ?? '';
    }

    public function getFooter(): string
    {
        [$message, $number] = match (true) {
            $this instanceof Incoming => [
                'Incoming message from {number}',
                $this->eventModel->phone_from ?? ''
            ],
            $this instanceof Outgoing => [
                'Sent message to {number}',
                $this->eventModel->phone_to ?? ''
            ],
            default => throw new LogicException(
                sprintf('Sms footer for sms event: "%s" not implemented', $this->historyModel->event)
            )
        };

        return Yii::t('app', $message, ['number' => $number]);
    }
}
