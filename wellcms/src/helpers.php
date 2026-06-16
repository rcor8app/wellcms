<?php

namespace WellCMS;

use WellCMS\Facades\WellCMS;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

if (! function_exists('WellCMS\authorize')) {
    /**
     * @throws AuthorizationException
     */
    function authorize(string $action, Model | string $model, bool $shouldCheckPolicyExistence = true): Response
    {
        $user = WellCMS::auth()->user();

        if (! $shouldCheckPolicyExistence) {
            return Gate::forUser($user)->authorize($action, Arr::wrap($model));
        }

        $policy = Gate::getPolicyFor($model);

        if (
            ($policy === null) ||
            (! method_exists($policy, $action))
        ) {
            /** @var bool | Response | null $response */
            $response = invade(Gate::forUser($user))->callBeforeCallbacks( /** @phpstan-ignore-line */
                $user,
                $action,
                [$model],
            );

            if ($response === false) {
                throw new AuthorizationException;
            }

            if (! $response instanceof Response) {
                return Response::allow();
            }

            return $response->authorize();
        }

        return Gate::forUser($user)->authorize($action, Arr::wrap($model));
    }
}
