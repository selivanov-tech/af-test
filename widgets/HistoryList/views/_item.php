<?php

use app\models\search\HistorySearch;

/** @var $model HistorySearch */
$widgetData = $model->getEventData();
if (is_null($widgetData)) {
    throw new \LogicException('Empty data for widget params.');
}

/** @var $this \yii\web\View */
echo $this->render($widgetData->viewName, $widgetData->toArray());
