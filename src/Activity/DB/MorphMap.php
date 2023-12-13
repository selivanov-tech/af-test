<?php

namespace app\src\Activity\DB;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\Sms;
use app\models\Task;
use app\models\User;
use InvalidArgumentException;

class MorphMap
{
    public static function getByClassName(string $className): string
    {
        return array_flip(self::map())[$className] ?? throw new InvalidArgumentException('...');
    }

    public static function map(): array
    {
        return [
            'customer' => Customer::class,
            'lead' => Customer::class,
            'deal' => Customer::class,
            'loan' => Customer::class,

            'sms' => Sms::class,
            'task' => Task::class,
            'call' => Call::class,
            'fax' => Fax::class,
            'user' => User::class,
            // ...
        ];
    }
}
