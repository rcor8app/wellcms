<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Contracts\HasTable;
use WellCMS\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DeleteBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'delete';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation();

        $this->label(__('wellcms-actions::delete.multiple.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::delete.multiple.modal.heading', ['label' => $this->getPluralModelLabel()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::delete.multiple.modal.actions.delete.label'));

        $this->successNotificationTitle(__('wellcms-actions::delete.multiple.notifications.deleted.title'));

        $this->defaultColor('danger');

        $this->icon(WellCMSIcon::resolve('actions::delete-action') ?? 'heroicon-m-trash');

        $this->modalIcon(WellCMSIcon::resolve('actions::delete-action.modal') ?? 'heroicon-o-trash');

        $this->action(function (): void {
            $this->process(static fn (Collection $records) => $records->each(fn (Model $record) => $record->delete()));

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();

        $this->hidden(function (HasTable $livewire): bool {
            $trashedFilterState = $livewire->getTableFilterState(TrashedFilter::class) ?? [];

            if (! array_key_exists('value', $trashedFilterState)) {
                return false;
            }

            if ($trashedFilterState['value']) {
                return false;
            }

            return filled($trashedFilterState['value']);
        });
    }
}
