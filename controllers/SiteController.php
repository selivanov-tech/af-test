<?php

namespace app\controllers;

use app\models\search\HistorySearch;
use app\src\Activity\HistoryEntry;
use app\src\Activity\Interfaces\IHistoryExporter;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @param string $exportType
     * @return string
     */
    public function actionExport($exportType)
    {
        $model = new HistorySearch();

        return $this->render('export', [
            'dataProvider' => $model->search(Yii::$app->request->queryParams),
            'exportType' => $exportType,
            'model' => $model
        ]);
    }

    public function actionExportOptimized()
    {
        /** @var HistoryEntry $historyEntry */
        $historyEntry = Yii::$app->history;

        $historyEntry->getExporter()->export();

        Yii::$app->end();
    }
}
