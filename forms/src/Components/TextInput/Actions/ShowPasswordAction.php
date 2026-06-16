<?php

namespace WellCMS\Forms\Components\TextInput\Actions;

use WellCMS\Forms\Components\Actions\Action;
use WellCMS\Support\Facades\WellCMSIcon;

class ShowPasswordAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'showPassword';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('wellcms-forms::components.text_input.actions.show_password.label'));

        $this->icon(WellCMSIcon::resolve('forms::components.text-input.actions.show-password') ?? 'heroicon-m-eye');

        $this->defaultColor('gray');

        $this->extraAttributes([
            'x-show' => '! isPasswordRevealed',
        ], merge: true);

        $this->alpineClickHandler('isPasswordRevealed = true');
    }
}
