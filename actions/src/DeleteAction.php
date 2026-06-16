<?php

namespace WellCMS\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends Action
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

        $this->label(__('wellcms-actions::delete.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::delete.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::delete.single.modal.actions.delete.label'));

        $this->successNotificationTitle(__('wellcms-actions::delete.single.notifications.deleted.title'));

        $this->defaultColor('danger');

        $this->groupedIcon(WellCMSIcon::resolve('actions::delete-action.grouped') ?? 'heroicon-m-trash');

        $this->modalIcon(WellCMSIcon::resolve('actions::delete-action.modal') ?? 'heroicon-o-trash');

        $this->keyBindings(['mod+d']);

        $this->hidden(static function (Model $record): bool {
            if (! method_exists($record, 'trashed')) {
                return false;
            }

            return $record->trashed();
        });

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->delete());

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
