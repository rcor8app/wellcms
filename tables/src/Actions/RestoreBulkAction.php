<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Contracts\HasTable;
use WellCMS\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RestoreBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'restore';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation();

        $this->label(__('wellcms-actions::restore.multiple.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::restore.multiple.modal.heading', ['label' => $this->getPluralModelLabel()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::restore.multiple.modal.actions.restore.label'));

        $this->successNotificationTitle(__('wellcms-actions::restore.multiple.notifications.restored.title'));

        $this->defaultColor('gray');

        $this->icon(WellCMSIcon::resolve('actions::restore-action') ?? 'heroicon-m-arrow-uturn-left');

        $this->modalIcon(WellCMSIcon::resolve('actions::restore-action.modal') ?? 'heroicon-o-arrow-uturn-left');

        $this->action(function (): void {
            $this->process(static function (Collection $records): void {
                $records->each(function (Model $record): void {
                    if (! method_exists($record, 'restore')) {
                        return;
                    }

                    $record->restore();
                });
            });

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();

        $this->hidden(function (HasTable $livewire): bool {
            $trashedFilterState = $livewire->getTableFilterState(TrashedFilter::class) ?? [];

            if (! array_key_exists('value', $trashedFilterState)) {
                return false;
            }

            return blank($trashedFilterState['value']);
        });
    }
}
