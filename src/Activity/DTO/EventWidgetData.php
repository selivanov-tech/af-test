<?php

namespace app\src\Activity\DTO;

use app\models\User;
use DateTime;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;

readonly class EventWidgetData implements Arrayable
{
    use ArrayableTrait;

    public function __construct(
        public string    $viewName,
        public User      $user,
        public string    $body,
        public string    $iconClass,
        public DateTime $footerDatetime,
        public string    $footer,
        public array     $oldNewValues = [],
    )
    {
    }
}
