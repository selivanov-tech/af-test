<?php

namespace app\models\traits;

use app\src\Activity\DB\MorphMap;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use LogicException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

trait HistoryRelatedObjectTrait
{
    /**
     * @param $name
     * @param bool $throwException
     * @return mixed
     */
    public function getRelation($name, $throwException = true)
    {
        $class = MorphMap::map()[$name] ?? null;
        if (null !== $class) {
            return $this->hasOne($class, ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }

    public function getRelatedObject(bool $fetchFromDB = true): ActiveRecord|ActiveQuery|null
    {
        $type = $this->object; // 'object' contains the type (e.g., 'task', 'customer')

        $map = MorphMap::map();

        $notMappedException = fn() => new LogicException(sprintf('"%s" object not mapped with morph.', $type));

        $loaded = MorphMap::checkAndGetRelationIfLoaded($this);

        return match (true) {
            !isset($map[$type]) => throw $notMappedException(),
            $loaded instanceof ActiveRecord => $loaded,
            $fetchFromDB === false => null,
            default => $this->hasOne($map[$type], ['id' => 'object_id'])
        };
    }

    public function getRelatedObjectEvent(bool $fetchFromDB = true): ?AbstractEventData
    {
        $relatedObject = $this->getRelatedObject($fetchFromDB);
        if (is_null($relatedObject)) {
            return null;
        }

        if (false === $relatedObject instanceof IHistoryAbleModel) {
            throw new LogicException(
                sprintf('Model [%s] should be history able', $relatedObject::class)
            );
        }

        return $relatedObject->historyEvents()->firstByHistoryModel($this);
    }
}
