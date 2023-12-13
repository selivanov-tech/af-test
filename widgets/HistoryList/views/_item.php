<?php

use app\models\search\HistorySearch;
use yii\web\View;

/** @var $model HistorySearch */
$widgetData = $model->getEventData();
if (is_null($widgetData)) {
    // todo: log
    throw new LogicException(
        sprintf('Empty data for widget params, model [%s], event [%s].',
            $model->relatedObject::class,
            $model->event
        )
    );
}

/** @var $this View */
echo $this->render($widgetData->viewName, $widgetData->toArray(recursive: false));
