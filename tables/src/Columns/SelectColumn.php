<?php

namespace WellCMS\Tables\Columns;

use WellCMS\Forms\Components\Concerns\CanDisableOptions;
use WellCMS\Forms\Components\Concerns\CanSelectPlaceholder;
use WellCMS\Forms\Components\Concerns\HasExtraInputAttributes;
use WellCMS\Forms\Components\Concerns\HasOptions;
use WellCMS\Tables\Columns\Contracts\Editable;
use Illuminate\Validation\Rule;

class SelectColumn extends Column implements Editable
{
    use CanDisableOptions;
    use CanSelectPlaceholder;
    use Concerns\CanBeValidated {
        getRules as baseGetRules;
    }
    use Concerns\CanUpdateState;
    use HasExtraInputAttributes;
    use HasOptions;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.select-column';

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabledClick();

        $this->placeholder(__('wellcms-forms::components.select.placeholder'));
    }

    /**
     * @return array<array-key>
     */
    public function getRules(): array
    {
        return [
            ...$this->baseGetRules(),
            Rule::in(array_keys($this->getOptions())),
        ];
    }
}
