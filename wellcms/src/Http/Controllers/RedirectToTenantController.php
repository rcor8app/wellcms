<?php

namespace WellCMS\Http\Controllers;

use WellCMS\Facades\WellCMS;
use WellCMS\Panel;
use Illuminate\Http\RedirectResponse;

class RedirectToTenantController
{
    public function __invoke(): RedirectResponse
    {
        $panel = WellCMS::getCurrentPanel();
        $tenant = WellCMS::getUserDefaultTenant(WellCMS::auth()->user());

        if (! $tenant) {
            return $this->redirectToTenantRegistration($panel);
        }

        $url = $panel->getUrl($tenant);

        if (blank($url)) {
            abort(404);
        }

        return redirect($url);
    }

    protected function redirectToTenantRegistration(Panel $panel): RedirectResponse
    {
        if (! ($panel->hasTenantRegistration() && wellcms()->getTenantRegistrationPage()::canView())) {
            abort(404);
        }

        return redirect($panel->getTenantRegistrationUrl());
    }
}
