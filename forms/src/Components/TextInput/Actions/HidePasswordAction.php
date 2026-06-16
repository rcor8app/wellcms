<?php

namespace WellCMS\Forms\Components\TextInput\Actions;

use WellCMS\Forms\Components\Actions\Action;
use WellCMS\Support\Facades\WellCMSIcon;

class HidePasswordAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'hidePassword';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('wellcms-forms::components.text_input.actions.hide_password.label'));

        $this->icon(WellCMSIcon::resolve('forms::components.text-input.actions.hide-password') ?? 'heroicon-m-eye-slash');

        $this->defaultColor('gray');

        $this->extraAttributes([
            'x-cloak' => true,
            'x-show' => 'isPasswordRevealed',
        ], merge: true);

        $this->alpineClickHandler('isPasswordRevealed = false');
    }
}
