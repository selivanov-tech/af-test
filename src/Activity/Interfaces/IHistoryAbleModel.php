<?php

namespace app\src\Activity\Interfaces;

use app\src\Activity\DTO\AbstractEventData;
use app\src\Activity\HistoryEvents\DomainEventCollection;
use yii\db\ActiveQueryInterface;

interface IHistoryAbleModel
{
    /**
     * Inverse polymorphic relation to History model
     */
    public function getHistory(): ActiveQueryInterface/* HasManyRelation */ ;

    /**
     * Collection of EventData DTOs
     * EventData will store logic specific to event
     * @return DomainEventCollection<AbstractEventData>
     */
    public function historyEvents(): DomainEventCollection;
}
