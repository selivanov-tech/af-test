<?php

namespace app\src\Activity\Traits;

use app\models\History;
use app\src\Activity\DB\MorphMap;
use yii\db\ActiveQueryInterface;

/**
 * @property-read History $history
 */
trait HistoryRelationTrait
{
    /**
     * Inverse polymorphic relation to History model
     */
    public function getHistory(): ActiveQueryInterface
    {
        return $this
            ->hasMany(History::class, ['object_id' => 'id'])
            ->where(['object' => MorphMap::getByClassName($this::class)]);
    }
}
