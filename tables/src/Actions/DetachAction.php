<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DetachAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'detach';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation();

        $this->label(__('wellcms-actions::detach.single.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::detach.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::detach.single.modal.actions.detach.label'));

        $this->successNotificationTitle(__('wellcms-actions::detach.single.notifications.detached.title'));

        $this->defaultColor('danger');

        $this->icon(WellCMSIcon::resolve('actions::detach-action') ?? 'heroicon-m-x-mark');

        $this->modalIcon(WellCMSIcon::resolve('actions::detach-action.modal') ?? 'heroicon-o-x-mark');

        $this->action(function (): void {
            $this->process(function (Model $record, Table $table): void {
                /** @var BelongsToMany $relationship */
                $relationship = $table->getRelationship();

                if ($table->allowsDuplicates()) {
                    $record->getRelationValue($relationship->getPivotAccessor())->delete();
                } else {
                    $relationship->detach($record);
                }
            });

            $this->success();
        });
    }
}
