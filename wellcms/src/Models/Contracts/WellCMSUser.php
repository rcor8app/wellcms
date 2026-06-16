<?php

namespace WellCMS\Models\Contracts;

use WellCMS\Panel;

interface WellCMSUser
{
    public function canAccessPanel(Panel $panel): bool;
}
