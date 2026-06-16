<?php

namespace WellCMS\Http\Controllers\Auth;

use WellCMS\Facades\WellCMS;
use WellCMS\Http\Responses\Auth\Contracts\LogoutResponse;

class LogoutController
{
    public function __invoke(): LogoutResponse
    {
        WellCMS::auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        return app(LogoutResponse::class);
    }
}
