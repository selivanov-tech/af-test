<?php

namespace app\src\Activity\DB;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\History;
use app\models\Sms;
use app\models\Task;
use app\models\User;
use InvalidArgumentException;
use yii\db\ActiveRecord;

class MorphMap
{
    public static function checkAndGetRelationIfLoaded(History $history): ?ActiveRecord
    {
        $relation = $history->{$history->object} ?? null;
        if ($relation instanceof ActiveRecord) {
            return $relation;
        }

        // check aliases
        $class = self::map()[$history->object] ?? null;
        if (is_null($class) || count(self::getByClassName($class)) <= 1) {
            return null;
        }

        $aliases = self::getByClassName($class);
        foreach ($aliases as $alias) {
            $aliasRelation = $history->$alias ?? null;

            if ($aliasRelation instanceof ActiveRecord) {
                return $aliasRelation;
            }
        }

        return null;
    }

    public static function getByClassName(string $className): array
    {
        $filtered = array_filter(
            self::map(),
            fn($class, $alias) => $class === $className,
            ARRAY_FILTER_USE_BOTH
        );

        return array_keys($filtered) ?? throw new InvalidArgumentException('...');
    }

    public static function getRelations(): array
    {
        $uniqueMap = [];

        foreach (self::map() as $type => $class) {
            if (!isset($uniqueMap[$class])) {
                $uniqueMap[$class] = $type;
            }
        }

        return array_values($uniqueMap);
    }

    public static function map(): array
    {
        return [
            'customer' => Customer::class,
            'lead' => Customer::class,
            'deal' => Customer::class,
            'loan' => Customer::class,

            'call' => Call::class,
            'call_ytel' => Call::class,

            'sms' => Sms::class,
            'task' => Task::class,
            'fax' => Fax::class,
            'user' => User::class,
            // ...
        ];
    }
}
