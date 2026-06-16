<?php

namespace WellCMS\Http\Middleware;

use WellCMS\Facades\WellCMS;
use WellCMS\Models\Contracts\WellCMSUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;

class Authenticate extends Middleware
{
    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = WellCMS::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            return; /** @phpstan-ignore-line */
        }

        $this->auth->shouldUse(WellCMS::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();

        $panel = WellCMS::getCurrentPanel();

        abort_if(
            $user instanceof WellCMSUser ?
                (! $user->canAccessPanel($panel)) :
                (config('app.env') !== 'local'),
            403,
        );
    }

    protected function redirectTo($request): ?string
    {
        return WellCMS::getLoginUrl();
    }
}
