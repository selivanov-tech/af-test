<?php

namespace app\src\Activity\DTO;

use app\models\User;
use DateTime;

readonly class CommonEventWidgetData extends AbstractEventWidgetData
{
    public function __construct(
        string          $viewName,
        public ?User    $user,
        public string   $body,
        public string   $iconClass,
        public DateTime $footerDatetime,
        public string   $footer,
        public array    $oldNewValues = [],
    )
    {
        parent::__construct(viewName: $viewName);
    }
}
