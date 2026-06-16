<?php

namespace WellCMS\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use WellCMS\Actions\Action;
use WellCMS\Actions\ActionGroup;
use WellCMS\Facades\WellCMS;
use WellCMS\Forms\Components\Checkbox;
use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\TextInput;
use WellCMS\Forms\Concerns\RestrictsFileUploadsToFormComponents;
use WellCMS\Forms\Form;
use WellCMS\Http\Responses\Auth\Contracts\LoginResponse;
use WellCMS\Models\Contracts\WellCMSUser;
use WellCMS\Notifications\Notification;
use WellCMS\Pages\Concerns\InteractsWithFormActions;
use WellCMS\Pages\SimplePage;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

/**
 * @property Form $form
 */
class Login extends SimplePage
{
    use InteractsWithFormActions;
    use RestrictsFileUploadsToFormComponents;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'wellcms-panels::pages.auth.login';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        if (WellCMS::auth()->check()) {
            redirect()->intended(WellCMS::getUrl());
        }

        $this->form->fill();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (! WellCMS::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = WellCMS::auth()->user();

        if (
            ($user instanceof WellCMSUser) &&
            (! $user->canAccessPanel(WellCMS::getCurrentPanel()))
        ) {
            WellCMS::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('wellcms-panels::pages/auth/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('wellcms-panels::pages/auth/login.notifications.throttled') ?: []) ? __('wellcms-panels::pages/auth/login.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('wellcms-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('wellcms-panels::pages/auth/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('wellcms-panels::pages/auth/login.form.password.label'))
            ->hint(wellcms()->hasPasswordReset() ? new HtmlString(Blade::render('<x-wellcms::link :href="wellcms()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'wellcms-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-wellcms::link>')) : null)
            ->password()
            ->revealable(wellcms()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('wellcms-panels::pages/auth/login.form.remember.label'));
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label(__('wellcms-panels::pages/auth/login.actions.register.label'))
            ->url(wellcms()->getRegistrationUrl());
    }

    public function getTitle(): string | Htmlable
    {
        return __('wellcms-panels::pages/auth/login.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('wellcms-panels::pages/auth/login.heading');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('wellcms-panels::pages/auth/login.form.actions.authenticate.label'))
            ->submit('authenticate');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }
}
