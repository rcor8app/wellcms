<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanCustomizeProcess;
use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DissociateBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'dissociate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation();

        $this->label(__('wellcms-actions::dissociate.multiple.label'));

        $this->modalHeading(fn (): string => __('wellcms-actions::dissociate.multiple.modal.heading', ['label' => $this->getPluralModelLabel()]));

        $this->modalSubmitActionLabel(__('wellcms-actions::dissociate.multiple.modal.actions.dissociate.label'));

        $this->successNotificationTitle(__('wellcms-actions::dissociate.multiple.notifications.dissociated.title'));

        $this->defaultColor('danger');

        $this->icon(WellCMSIcon::resolve('actions::dissociate-action') ?? 'heroicon-m-x-mark');

        $this->modalIcon(WellCMSIcon::resolve('actions::dissociate-action.modal') ?? 'heroicon-o-x-mark');

        $this->action(function (): void {
            $this->process(function (Collection $records, Table $table): void {
                $records->each(function (Model $record) use ($table): void {
                    /** @var BelongsTo $inverseRelationship */
                    $inverseRelationship = $table->getInverseRelationshipFor($record);

                    $inverseRelationship->dissociate();
                    $record->save();
                });
            });

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }
}
