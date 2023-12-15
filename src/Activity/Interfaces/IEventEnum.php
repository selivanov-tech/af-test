<?php

namespace app\src\Activity\Interfaces;


interface IEventEnum
{
    public function getI18nTexts(string $property): array;

    public function getI18nTextByValue(string $value): string;
}
