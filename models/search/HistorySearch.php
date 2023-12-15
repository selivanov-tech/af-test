<?php

namespace app\models\search;

use app\models\History;
use app\src\Activity\DB\HistoryActiveQuery;
use app\src\Activity\DTO\AbstractEventWidgetData;
use app\src\Activity\DTO\CommonEventWidgetData;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\validators\InlineValidator;

/**
 * HistorySearch represents the model behind the search form about `app\models\History`.
 *
 * @property array $objects
 */
class HistorySearch extends History
{
    public static function find(): HistoryActiveQuery
    {
        return Yii::createObject(HistoryActiveQuery::class, [get_called_class()]);
    }

    public function validateEvent(string $attribute, mixed $params, InlineValidator $validator): void
    {
        return;
    }

    public function getEventData(): ?AbstractEventWidgetData
    {
        $event = $this->getRelatedObjectEvent(fetchFromDB: false)?->getWidgetData();
        if (is_null($event)) {
            // todo: log or/and delete history record
            return CommonEventWidgetData::createFromDeleted($this);
        }

        return $event;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this::find();

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setPagination(new Pagination(['totalCount' => $count]));

        $dataProvider->setSort([
            'defaultOrder' => [
                'ins_ts' => SORT_DESC,
                'id' => SORT_DESC
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->addSelect('history.*')
            ->with('user')
            ->withHistoryRelations();

        return $dataProvider;
    }
}
