<?php

namespace WellCMS\Infolists\Components\Contracts;

use WellCMS\Infolists\Components\Actions\Action;

interface HasHintActions
{
    /**
     * @return array<Action>
     */
    public function getHintActions(): array;
}
