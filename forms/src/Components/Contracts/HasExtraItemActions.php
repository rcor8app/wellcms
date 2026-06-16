<?php

namespace WellCMS\Forms\Components\Contracts;

use WellCMS\Forms\Components\Actions\Action;

interface HasExtraItemActions
{
    /**
     * @return array<Action>
     */
    public function getExtraItemActions(): array;
}
