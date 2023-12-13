<?php

use app\models\search\HistorySearch;
use yii\web\View;

/** @var $model HistorySearch */
$widgetData = $model->getEventData();
if (is_null($widgetData)) {
    throw new LogicException('Empty data for widget params.');
}

/** @var $this View */
echo $this->render($widgetData->viewName, $widgetData->toArray(recursive: false));
