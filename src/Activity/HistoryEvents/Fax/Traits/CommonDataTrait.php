<?php

namespace app\src\Activity\HistoryEvents\Fax\Traits;

use app\src\Activity\DTO\CommonEventWidgetData;
use DateTime;
use Yii;
use yii\helpers\Html;

trait CommonDataTrait
{
    public function getWidgetData(): CommonEventWidgetData
    {
        $fax = $this->eventModel;

        return new CommonEventWidgetData(
            viewName: '_item_common',
            user: null,
            body: $this->getBody(),
            iconClass: 'fa-fax bg-green',
            footerDatetime: new DateTime($this->historyModel->ins_ts),
            footer: Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ])
        );
    }

    public function getBody(): string
    {
        $fax = $this->eventModel;

        $secondBodyPiece = '';
        if (isset($fax->document)) {
            $secondBodyPiece = Html::a(
                Yii::t('app', 'view document'),
                $fax->document->getViewUrl(),
                [
                    'target' => '_blank',
                    'data-pjax' => 0
                ]
            );
        }

        return sprintf('%s - %s', $this->historyModel->eventText, $secondBodyPiece);
    }
}
