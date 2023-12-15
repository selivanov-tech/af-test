<?php

namespace app\src\Activity\HistoryEvents\Customer\Interfaces;

interface IHaveChangedColumnValue
{
    public static function getChangedColumnName(): string;
}
