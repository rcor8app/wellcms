<?php

namespace WellCMS\Infolists\Components\Contracts;

use WellCMS\Infolists\Components\Actions\Action;

interface HasFooterActions
{
    /**
     * @return array<Action>
     */
    public function getFooterActions(): array;
}
