<?php

namespace WellCMS\Http\Controllers\Auth;

use WellCMS\Http\Responses\Auth\Contracts\EmailVerificationResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController
{
    public function __invoke(EmailVerificationRequest $request): EmailVerificationResponse
    {
        $request->fulfill();

        return app(EmailVerificationResponse::class);
    }
}
