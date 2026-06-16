<?php

namespace WellCMS\Actions;

use Closure;
use WellCMS\Actions\Contracts\HasActions;
use WellCMS\Support\Facades\WellCMSIcon;
use Illuminate\Database\Eloquent\Model;

class ViewAction extends Action
{
    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'view';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('wellcms-actions::view.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::view.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitAction(false);
        $this->modalCancelAction(fn (StaticAction $action) => $action->label(__('wellcms-actions::view.single.modal.actions.close.label')));

        $this->defaultColor('gray');

        $this->groupedIcon(WellCMSIcon::resolve('actions::view-action.grouped') ?? 'heroicon-m-eye');

        $this->disabledForm();

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
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
