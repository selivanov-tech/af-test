<?php

/**
 * @var $this yii\web\View
 * @var $model History
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $exportType string
 */

use app\models\History;
use app\models\search\HistorySearch;
use app\src\Activity\DTO\Interfaces\IEventWithBody;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use app\widgets\Export\Export;

$filename = 'history';
$filename .= '-' . time();

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>

<?= Export::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'ins_ts',
            'label' => Yii::t('app', 'Date'),
            'format' => 'datetime'
        ],
        [
            'label' => Yii::t('app', 'User'),
            'value' => function (HistorySearch $model) {
                return isset($model->user) ? $model->user->username : Yii::t('app', 'System');
            }
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'value' => function (HistorySearch $model) {
                return $model->object;
            }
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'value' => function (HistorySearch $model) {
                return $model->eventText;
            }
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'value' => function (HistorySearch $model) {
                if (false === $model->relatedObject instanceof IHistoryAbleModel) {
                    return '';
                }

                $historyEvent = $model->getRelatedObjectEvent();
                if (false === $historyEvent instanceof IEventWithBody) {
                    return '';
                }

                $eventMessage = $historyEvent->getBody();

                return strip_tags($eventMessage);
            }
        ]
    ],
    'exportType' => $exportType,
    'batchSize' => 2000,
    'filename' => $filename
]);
