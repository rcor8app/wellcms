<?php

namespace WellCMS\Tables\Columns;

use WellCMS\Forms\Components\Concerns\HasToggleColors;
use WellCMS\Forms\Components\Concerns\HasToggleIcons;
use WellCMS\Tables\Columns\Contracts\Editable;

class ToggleColumn extends Column implements Editable
{
    use Concerns\CanBeValidated;
    use Concerns\CanUpdateState;
    use HasToggleColors;
    use HasToggleIcons;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.toggle-column';

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabledClick();

        $this->rules(['boolean']);
    }
}
