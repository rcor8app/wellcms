<?php

namespace WellCMS\Actions\Contracts;

use WellCMS\Actions\Action;
use WellCMS\Support\Contracts\TranslatableContentDriver;

interface HasActions
{
    /**
     * @param  string | array<string>  $name
     */
    public function getAction(string | array $name): ?Action;

    public function getActiveActionsLocale(): ?string;

    public function makeWellCMSTranslatableContentDriver(): ?TranslatableContentDriver;
}
