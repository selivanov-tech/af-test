<?php

namespace app\src\Activity\DB;

use app\models\search\HistorySearch;
use yii\db\ActiveQuery;

class HistoryActiveQuery extends ActiveQuery
{
    public function findWith($with, &$models)
    {
        $nonHistoryRelations = [];
        foreach ($with as $name => $value) {
            $relation = $name;
            if (is_int($name)) {
                $relation = $value;
            }

            $isHistoryRelation = in_array($relation, MorphMap::getRelations());
            if ($isHistoryRelation) {
                $filtered = $this->getOnlyRelatedModels($relation, $models);

                parent::findWith([$relation], $filtered);

                continue;
            }

            if (is_int($name)) {
                $nonHistoryRelations[] = $value;
            } else {
                $nonHistoryRelations[$name] = $value;
            }
        }

        if (!empty($nonHistoryRelations)) {
            parent::findWith($nonHistoryRelations, $models);
        }
    }

    public function withHistoryRelations(): self
    {
        return $this->with(MorphMap::getRelations());
    }

    /**
     * @param string $relation
     * @param HistorySearch[] $models
     */
    private function getOnlyRelatedModels(string $relation, array $models): array
    {
        $relationClass = MorphMap::map()[$relation];
        $relationAliases = MorphMap::getByClassName($relationClass);
        $filtered = [];

        foreach ($models as $model) {
            if (in_array($model->object, $relationAliases)) {
                $filtered[] = $model;
            }
        }

        return $filtered;
    }
}
