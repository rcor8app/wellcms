<?php

namespace WellCMS\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use Illuminate\Database\Eloquent\Model;

class RestoreAction extends Action
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

        $this->label(__('wellcms-actions::restore.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::restore.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::restore.single.modal.actions.restore.label'));

        $this->successNotificationTitle(__('wellcms-actions::restore.single.notifications.restored.title'));

        $this->defaultColor('gray');

        $this->groupedIcon(WellCMSIcon::resolve('actions::restore-action.grouped') ?? 'heroicon-m-arrow-uturn-left');

        $this->modalIcon(WellCMSIcon::resolve('actions::restore-action.modal') ?? 'heroicon-o-arrow-uturn-left');

        $this->action(function (Model $record): void {
            if (! method_exists($record, 'restore')) {
                $this->failure();

                return;
            }

            $result = $this->process(static fn () => $record->restore());

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });

        $this->visible(static function (Model $record): bool {
            if (! method_exists($record, 'trashed')) {
                return false;
            }

            return $record->trashed();
        });
    }
}
