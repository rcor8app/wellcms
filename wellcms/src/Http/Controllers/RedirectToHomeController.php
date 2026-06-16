<?php

namespace WellCMS\Http\Controllers;

use WellCMS\Facades\WellCMS;
use Illuminate\Http\RedirectResponse;

class RedirectToHomeController
{
    public function __invoke(): RedirectResponse
    {
        $panel = WellCMS::getCurrentPanel();

        $url = $panel->getUrl(WellCMS::getTenant());

        if (blank($url)) {
            abort(404);
        }

        return redirect($url);
    }
}
