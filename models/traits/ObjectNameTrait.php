<?php

namespace app\models\traits;

use app\src\Activity\DB\MorphMap;

trait ObjectNameTrait
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
}
