<?php

namespace app\src\Activity\HistoryEvents\Call\Traits;

use app\models\Call;
use app\src\Activity\DTO\CommonEventWidgetData;
use DateTime;

trait CommonDataTrait
{
    public function getWidgetData(): CommonEventWidgetData
    {
        $call = $this->eventModel;
        $answered = $call->status == Call::STATUS_ANSWERED;

        return new CommonEventWidgetData(
            viewName: '_item_common',
            user: $this->historyModel->user,
            body: $this->getBody(),
            iconClass: $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            // todo: implement? not used anywhere
            // iconIncome: $answered && $call->direction == Call::DIRECTION_INCOMING,
            footerDatetime: new DateTime($this->historyModel->ins_ts),
            footer: isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            content: $call->comment ?? ''
        );
    }

    public function getBody(): string
    {
        $call = $this->eventModel;

        if (is_null($call->getPrimaryKey())) {
            return '<i>Deleted call</i>';
        }

        $secondBodyPiece = "";
        if ($disposition = $call->getTotalDisposition(false)) {
            $secondBodyPiece = " <span class='text-grey'>$disposition</span>";
        }

        return $call->totalStatusText . $secondBodyPiece;
    }
}
