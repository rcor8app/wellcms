<?php

namespace WellCMS\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use Illuminate\Database\Eloquent\Model;

class ForceDeleteAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'forceDelete';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation();

        $this->label(__('wellcms-actions::force-delete.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::force-delete.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::force-delete.single.modal.actions.delete.label'));

        $this->defaultColor('danger');

        $this->groupedIcon(WellCMSIcon::resolve('actions::force-delete-action.grouped') ?? 'heroicon-m-trash');

        $this->modalIcon(WellCMSIcon::resolve('actions::force-delete-action.modal') ?? 'heroicon-o-trash');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->forceDelete());

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
