<?php

namespace app\src\Activity\DTO;

use app\models\History;
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
        public ?string  $footer,
        public ?string  $content = null,
        public array    $oldNewValues = [],
    )
    {
        parent::__construct(viewName: $viewName);
    }

    public static function createFromDeleted(History $history): self
    {
        return new self(
            viewName: '_item_common',
            user: $history->user,
            body: sprintf('Related object: "%s" for history\'s event "%s" was deleted.',
                $history->object,
                $history->event
            ),
            iconClass: 'bg-red',
            footerDatetime: new DateTime($history->ins_ts),
            footer: null,
            content: null
        );
    }
}
