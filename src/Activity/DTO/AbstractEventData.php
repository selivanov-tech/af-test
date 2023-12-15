<?php

namespace app\src\Activity\DTO;


use app\models\History;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use LogicException;
use yii\db\ActiveRecord;

abstract class AbstractEventData
{
    public const EVENT_NAME = '';

    public function __construct(
        public readonly History                        $historyModel,
        public readonly IHistoryAbleModel|ActiveRecord $eventModel,
        /**
         * Stores event's name and i18n logic
         * e.g. TaskEventEnum::created_task | ...updated_task| ...completed_task
         * interface IEventEnum:
         *      public function getI18nTexts(): array;
         *      public function getI18nTextByValue(string $value): string;
         */
//        todo: public readonly \BackedEnum|IEventEnum         $eventEnum,
    )
    {
        assert(!empty(static::getEventName()), new LogicException('Event name shouldn\'t be empty.'));
    }

    abstract public static function getEventName(): string;

    abstract public function getWidgetData(): AbstractEventWidgetData;
}
