<?php

namespace app\src\Activity\DTO;

use app\models\History;

readonly class OldNewEventWidgetData extends AbstractEventWidgetData
{
    public function __construct(
        string         $viewName,
        public History $model,
        public ?string $oldValue,
        public ?string $newValue,
    )
    {
        parent::__construct(viewName: $viewName);
    }
}
