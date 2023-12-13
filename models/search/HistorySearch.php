<?php

namespace app\models\search;

use app\models\History;
use app\src\Activity\DTO\AbstractEventWidgetData;
use app\src\Activity\DTO\CommonEventWidgetData;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use LogicException;
use yii\data\ActiveDataProvider;
use yii\validators\InlineValidator;

/**
 * HistorySearch represents the model behind the search form about `app\models\History`.
 *
 * @property array $objects
 */
class HistorySearch extends History
{
    public function validateEvent(string $attribute, mixed $params, InlineValidator $validator): void
    {
        return;
    }

    public function getEventData(): ?AbstractEventWidgetData
    {
        if (is_null($this->relatedObject)) {
            // todo: log or/and delete history record
            return CommonEventWidgetData::createFromDeleted($this);
        }

        if (false === $this->relatedObject instanceof IHistoryAbleModel) {
            throw new LogicException(
                sprintf('Model [%s] should be history able', $this->relatedObject::class)
            );
        }

        return $this
            ->relatedObject
            ?->historyEvents()
            ->firstByHistoryModel($this)
            ?->getWidgetData();
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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

        $query->addSelect('history.*');
        $query->with([
            'customer',
            'user',
            'sms',
            'task',
            'call',
            'fax',
        ]);

        return $dataProvider;
    }
}
