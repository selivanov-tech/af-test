<?php

namespace app\src\Activity;

use app\src\Activity\Export\CSVExporter;
use app\src\Activity\Interfaces\IHistoryExporter;
use Yii;
use yii\base\BaseObject;

class HistoryEntry extends BaseObject
{
    public function init(): void
    {
        Yii::$container->set(IHistoryExporter::class, CSVExporter::class);
    }

    public function getExporter(): IHistoryExporter
    {
        return Yii::$container->get(IHistoryExporter::class);
    }
}
