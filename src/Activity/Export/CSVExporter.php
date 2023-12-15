<?php

namespace app\src\Activity\Export;

use app\models\History;
use app\models\search\HistorySearch;
use app\src\Activity\DTO\Interfaces\IEventWithBody;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use app\src\Activity\Interfaces\IHistoryExporter;
use Throwable;
use Yii;

class CSVExporter implements IHistoryExporter
{
    public function export(): void
    {
        try {
            $fileName = sprintf('history_export-%s.csv', time());

            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$fileName");

            Yii::$app->state = Yii::$app::STATE_SENDING_RESPONSE;

            ob_start();

            $this->generateExportContent();
        } catch (Throwable $ex) {
            // todo: log
            throw $ex;
        } finally {
            ob_end_clean();
        }
    }

    private function generateExportContent()
    {
        $dataProvider = (new HistorySearch)->search(Yii::$app->request->queryParams);

        // Extract 'label' values from the array
        $headers = array_column(array_map(function ($item) {
            return $item['label'] ?? '';
        }, $this->getColumns()), null);

        // Output CSV headers
        echo implode(',', $headers) . PHP_EOL;

        foreach ($dataProvider->query->batch(1000) as $i => $historyRecords) {
            foreach ($historyRecords as $history) {
                echo implode(',', $this->getRowValues($history)) . PHP_EOL;
            }

            // Flush the output buffer and send content to the client
            ob_flush();
            flush();
        }
    }

    private function getRowValues(History $history): array
    {
        $values = [];

        foreach ($this->getColumns() as $column) {
            $modelProp = $column['attribute'] ?? null;
            if (null !== $modelProp) {
                $values[] = $history->$modelProp;

                continue;
            }

            $value = $column['value'] ?? null;
            if (null !== $value || is_callable($value)) {
                $values[] = $value($history);
            }
        }

        return $values;
    }

    private function getColumns(): array
    {
        return [
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
                    if (false === $model->getRelatedObject(fetchFromDB: false) instanceof IHistoryAbleModel) {
                        return '';
                    }

                    $historyEvent = $model->getRelatedObjectEvent(fetchFromDB: false);
                    if (false === $historyEvent instanceof IEventWithBody) {
                        return '';
                    }

                    $eventMessage = $historyEvent->getBody();

                    return strip_tags($eventMessage);
                }
            ]
        ];
    }
}
