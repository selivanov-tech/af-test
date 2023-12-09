<?php

namespace app\src\Activity\HistoryEvents;

use app\models\History;
use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\Interfaces\IHistoryAbleModel;
use AssertionError;
use ReflectionClass;
use ReflectionException;
use yii\db\ActiveRecord;

class DomainEventCollection
{
    protected function __construct(
        protected ActiveRecord|IHistoryAbleModel $model,
        /**
         * Stores event's classes as string
         * @var array<string>
         */
        private readonly array                   $events
    )
    {
    }

    public static function create(ActiveRecord $model, array $events): self
    {
        array_map(
            callback: fn(mixed $event) => self::assertEvent($event),
            array: $events
        );

        return new self($model, $events);
    }

    public function firstByHistoryModel(History $history): ?AbstractEventData
    {
        foreach ($this->events as $event) {
            if ($event::EVENT_NAME === $history->event) {
                return new $event($history, $this->model);
            }
        }

        return null;
    }

    /**
     * @throws ReflectionException|AssertionError
     */
    protected static function assertEvent(mixed $event): void
    {
        $reflector = new ReflectionClass($event);
        assert($reflector->isInstantiable());
        assert($reflector->isSubclassOf(AbstractEventData::class));
    }
}
