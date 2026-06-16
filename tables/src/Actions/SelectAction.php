<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns;

class SelectAction extends Action
{
    use Concerns\HasSelect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->view('wellcms-actions::select-action');
    }
}
