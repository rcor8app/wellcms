<?php

namespace WellCMS\Models\Contracts;

interface HasCurrentTenantLabel
{
    public function getCurrentTenantLabel(): string;
}
