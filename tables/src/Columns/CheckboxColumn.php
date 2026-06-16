<?php

namespace WellCMS\Tables\Columns;

use WellCMS\Forms\Components\Concerns\HasExtraInputAttributes;
use WellCMS\Tables\Columns\Contracts\Editable;

class CheckboxColumn extends Column implements Editable
{
    use Concerns\CanBeValidated;
    use Concerns\CanUpdateState;
    use HasExtraInputAttributes;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.checkbox-column';

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabledClick();

        $this->rules(['boolean']);
    }
}
