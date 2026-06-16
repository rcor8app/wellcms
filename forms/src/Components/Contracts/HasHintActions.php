<?php

namespace WellCMS\Forms\Components\Contracts;

use WellCMS\Forms\Components\Actions\Action;

interface HasHintActions
{
    /**
     * @return array<Action>
     */
    public function getHintActions(): array;
}
