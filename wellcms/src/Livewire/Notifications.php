<?php

namespace WellCMS\Livewire;

use WellCMS\Facades\WellCMS;
use WellCMS\Notifications\Livewire\Notifications as BaseComponent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Notifications extends BaseComponent
{
    public function getUser(): Model | Authenticatable | null
    {
        return WellCMS::auth()->user();
    }
}
