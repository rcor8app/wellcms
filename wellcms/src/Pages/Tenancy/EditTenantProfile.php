<?php

namespace WellCMS\Pages\Tenancy;

use WellCMS\Actions\Action;
use WellCMS\Actions\ActionGroup;
use WellCMS\Facades\WellCMS;
use WellCMS\Forms\Form;
use WellCMS\Notifications\Notification;
use WellCMS\Pages\Concerns;
use WellCMS\Pages\Page;
use WellCMS\Panel;
use WellCMS\Support\Exceptions\Halt;
use WellCMS\Support\Facades\WellCMSView;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Locked;
use Throwable;

use function WellCMS\authorize;

/**
 * @property Form $form
 */
abstract class EditTenantProfile extends Page
{
    use Concerns\CanUseDatabaseTransactions;
    use Concerns\HasRoutes;
    use Concerns\InteractsWithFormActions;

    /**
     * @var view-string
     */
    protected static string $view = 'wellcms-panels::pages.tenancy.edit-tenant-profile';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    /**
     * @var ?Model
     */
    #[Locked]
    public $tenant = null;

    protected static bool $isDiscovered = false;

    abstract public static function getLabel(): string;

    public static function getRelativeRouteName(): string
    {
        return 'profile';
    }

    public static function getRouteName(?string $panel = null): string
    {
        $panel = $panel ? WellCMS::getPanel($panel) : WellCMS::getCurrentPanel();

        return $panel->generateRouteName('tenant.' . static::getRelativeRouteName());
    }

    public static function isTenantSubscriptionRequired(Panel $panel): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->tenant = WellCMS::getTenant();

        abort_unless(static::canView($this->tenant), 404);

        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $data = $this->tenant->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            $this->handleRecordUpdate($this->tenant, $data);

            $this->callHook('afterSave');
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

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: WellCMSView::hasSpaMode($redirectUrl));
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($title);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('wellcms-panels::pages/tenancy/edit-tenant-profile.notifications.saved.title');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
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
                    ->operation('edit')
                    ->model($this->tenant)
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('wellcms-panels::pages/tenancy/edit-tenant-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public function getTitle(): string | Htmlable
    {
        return static::getLabel();
    }

    public static function getSlug(): string
    {
        return static::$slug ?? 'profile';
    }

    public static function canView(Model $tenant): bool
    {
        try {
            return authorize('update', $tenant)->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
