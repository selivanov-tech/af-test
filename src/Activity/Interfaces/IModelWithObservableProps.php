<?php

namespace app\src\Activity\Interfaces;

interface IModelWithObservableProps
{
    /**
     * Columns which we need to store on UPDATE_EVENT as old/new in history.detail
     * @return array<string>
     */
    public function initObservableDirtyProps(): array;
}
