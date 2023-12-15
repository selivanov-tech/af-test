<?php

namespace app\src\Activity\DTO;

use yii\base\Arrayable;
use yii\base\ArrayableTrait;

readonly class AbstractEventWidgetData implements Arrayable
{
    use ArrayableTrait;

    public function __construct(
        public string $viewName,
    )
    {
    }
}
