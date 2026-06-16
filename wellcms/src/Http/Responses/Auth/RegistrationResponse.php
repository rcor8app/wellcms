<?php

namespace WellCMS\Http\Responses\Auth;

use WellCMS\Facades\WellCMS;
use WellCMS\Http\Responses\Auth\Contracts\RegistrationResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class RegistrationResponse implements Responsable
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        return redirect()->intended(WellCMS::getUrl());
    }
}
