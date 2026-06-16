<?php

namespace WellCMS\Infolists\Components\Contracts;

use WellCMS\Infolists\Components\Actions\Action;

interface HasAffixActions
{
    /**
     * @return array<Action>
     */
    public function getPrefixActions(): array;

    /**
     * @return array<Action>
     */
    public function getSuffixActions(): array;
}
