<?php

namespace WellCMS\Models\Contracts;

use WellCMS\Panel;
use Illuminate\Database\Eloquent\Model;

interface HasDefaultTenant
{
    public function getDefaultTenant(Panel $panel): ?Model;
}
