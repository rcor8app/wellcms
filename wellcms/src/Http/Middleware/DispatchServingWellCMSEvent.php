<?php

namespace WellCMS\Http\Middleware;

use Closure;
use WellCMS\Events\ServingWellCMS;
use Illuminate\Http\Request;

class DispatchServingWellCMSEvent
{
    public function handle(Request $request, Closure $next): mixed
    {
        ServingWellCMS::dispatch();

        return $next($request);
    }
}
