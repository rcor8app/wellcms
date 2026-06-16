<?php

namespace WellCMS\Models\Contracts;

use WellCMS\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HasTenants
{
    public function canAccessTenant(Model $tenant): bool;

    /**
     * @return array<Model> | Collection
     */
    public function getTenants(Panel $panel): array | Collection;
}
