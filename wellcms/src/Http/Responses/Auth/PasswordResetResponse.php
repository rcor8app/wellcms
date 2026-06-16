<?php

namespace WellCMS\Http\Responses\Auth;

use WellCMS\Facades\WellCMS;
use WellCMS\Http\Responses\Auth\Contracts\PasswordResetResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class PasswordResetResponse implements Responsable
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        return redirect()->to(
            WellCMS::hasLogin() ? WellCMS::getLoginUrl() : WellCMS::getUrl(),
        );
    }
}
