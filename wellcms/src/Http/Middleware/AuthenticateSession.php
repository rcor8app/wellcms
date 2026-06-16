<?php

namespace WellCMS\Http\Middleware;

use WellCMS\Facades\WellCMS;
use Illuminate\Session\Middleware\AuthenticateSession as Middleware;

class AuthenticateSession extends Middleware
{
    protected function redirectTo($request): ?string
    {
        return WellCMS::getLoginUrl();
    }
}
