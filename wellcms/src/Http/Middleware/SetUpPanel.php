<?php

namespace WellCMS\Http\Middleware;

use Closure;
use WellCMS\Facades\WellCMS;
use Illuminate\Http\Request;

class SetUpPanel
{
    public function handle(Request $request, Closure $next, string $panel): mixed
    {
        $panel = WellCMS::getPanel($panel);

        WellCMS::setCurrentPanel($panel);

        WellCMS::bootCurrentPanel();

        return $next($request);
    }
}
