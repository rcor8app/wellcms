<?php

namespace WellCMS\Tables\Actions;

/**
 * @deprecated Use `\WellCMS\Tables\Actions\Action` instead, with the `iconButton()` method.
 * @see Action
 */
class IconButtonAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->iconButton();
    }
}
