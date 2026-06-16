<?php

namespace WellCMS\Resources\Pages\Concerns;

use WellCMS\Actions\Action;
use WellCMS\Actions\ActionGroup;
use WellCMS\Forms\Components\Wizard;
use WellCMS\Forms\Form;

trait HasWizard
{
    public function getStartStep(): int
    {
        return 1;
    }

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps()),
            ])
            ->columns(null);
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getFormActions(): array
    {
        return [];
    }

    public function getSteps(): array
    {
        return [];
    }

    protected function hasSkippableSteps(): bool
    {
        return false;
    }
}
