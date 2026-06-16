<?php

namespace WellCMS\Forms\Components\Contracts;

use WellCMS\Forms\Components\Actions\Action;

interface HasHeaderActions
{
    /**
     * @return array<Action>
     */
    public function getHeaderActions(): array;
}
