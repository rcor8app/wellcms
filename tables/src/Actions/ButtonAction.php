<?php

namespace WellCMS\Tables\Actions;

/**
 * @deprecated Use `\WellCMS\Tables\Actions\Action` instead, with the `button()` method.
 * @see Action
 */
class ButtonAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->button();
    }
}
