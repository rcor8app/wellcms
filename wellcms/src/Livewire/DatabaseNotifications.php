<?php

namespace WellCMS\Livewire;

use WellCMS\Facades\WellCMS;
use WellCMS\Notifications\Livewire\DatabaseNotifications as BaseComponent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class DatabaseNotifications extends BaseComponent
{
    public function getUser(): Model | Authenticatable | null
    {
        return WellCMS::auth()->user();
    }

    public function getPollingInterval(): ?string
    {
        return WellCMS::getDatabaseNotificationsPollingInterval();
    }

    public function getTrigger(): View
    {
        return view('wellcms-panels::components.topbar.database-notifications-trigger');
    }
}
