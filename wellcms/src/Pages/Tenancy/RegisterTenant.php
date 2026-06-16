<?php

namespace WellCMS\Pages\Tenancy;

use WellCMS\Actions\Action;
use WellCMS\Actions\ActionGroup;
use WellCMS\Facades\WellCMS;
use WellCMS\Forms\Form;
use WellCMS\Pages\Concerns;
use WellCMS\Pages\Concerns\InteractsWithFormActions;
use WellCMS\Pages\SimplePage;
use WellCMS\Panel;
use WellCMS\Support\Exceptions\Halt;
use WellCMS\Support\Facades\WellCMSView;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Throwable;

use function WellCMS\authorize;

/**
 * @property Form $form
 */
abstract class RegisterTenant extends SimplePage
{
    use Concerns\CanUseDatabaseTransactions;
    use Concerns\HasRoutes;
    use InteractsWithFormActions;

    /**
     * @var view-string
     */
    protected static string $view = 'wellcms-panels::pages.tenancy.register-tenant';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public ?Model $tenant = null;

    abstract public static function getLabel(): string;

    public static function getRelativeRouteName(): string
    {
        return 'registration';
    }

    public static function isTenantSubscriptionRequired(Panel $panel): bool
    {
        return false;
    }

    public function mount(): void
    {
        abort_unless(static::canView(), 404);

        $this->form->fill();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        return $data;
    }

    public function register(): void
    {
        abort_unless(static::canView(), 404);

        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $this->tenant = $this->handleRegistration($data);

            $this->form->model($this->tenant)->saveRelationships();

            $this->callHook('afterRegister');
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->commitDatabaseTransaction();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: WellCMSView::hasSpaMode($redirectUrl));
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        return $this->getModel()::create($data);
    }

    protected function getRedirectUrl(): ?string
    {
        return WellCMS::getUrl($this->tenant);
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
                    ->model($this->getModel())
                    ->statePath('data'),
            ),
        ];
    }

    public function getModel(): string
    {
        return WellCMS::getTenantModel();
    }

    public function getTitle(): string | Htmlable
    {
        return static::getLabel();
    }

    public static function getSlug(): string
    {
        return static::$slug ?? 'new';
    }

    public function hasLogo(): bool
    {
        return false;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(static::getLabel())
            ->submit('register');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    public static function canView(): bool
    {
        try {
            return authorize('create', WellCMS::getTenantModel())->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
