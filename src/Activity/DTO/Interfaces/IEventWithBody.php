<?php

namespace app\src\Activity\DTO\Interfaces;

interface IEventWithBody
{
    public function getBody(): string;
}
