<?php

namespace WellCMS\Infolists\Contracts;

use WellCMS\Infolists\Infolist;

interface HasInfolists
{
    public function getInfolist(string $name): ?Infolist;
}
