<?php

namespace WellCMS\Actions;

use Closure;
use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Actions\Contracts\HasActions;
use WellCMS\Support\Facades\WellCMSIcon;
use Illuminate\Database\Eloquent\Model;

class EditAction extends Action
{
    use CanCustomizeProcess;

    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'edit';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('wellcms-actions::edit.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::edit.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::edit.single.modal.actions.save.label'));

        $this->successNotificationTitle(__('wellcms-actions::edit.single.notifications.saved.title'));

        $this->groupedIcon(WellCMSIcon::resolve('actions::edit-action.grouped') ?? 'heroicon-m-pencil-square');

        $this->fillForm(function (HasActions $livewire, Model $record): array {
            if ($translatableContentDriver = $livewire->makeWellCMSTranslatableContentDriver()) {
                $data = $translatableContentDriver->getRecordAttributesToArray($record);
            } else {
                $data = $record->attributesToArray();
            }

            if ($this->mutateRecordDataUsing) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            return $data;
        });

        $this->action(function (): void {
            $this->process(function (array $data, HasActions $livewire, Model $record) {
                if ($translatableContentDriver = $livewire->makeWellCMSTranslatableContentDriver()) {
                    $translatableContentDriver->updateRecord($record, $data);
                } else {
                    $record->update($data);
                }
            });

            $this->success();
        });
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
