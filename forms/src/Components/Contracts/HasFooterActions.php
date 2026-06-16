<?php

namespace WellCMS\Forms\Components\Contracts;

use WellCMS\Forms\Components\Actions\Action;

interface HasFooterActions
{
    /**
     * @return array<Action>
     */
    public function getFooterActions(): array;
}
