<?php

namespace WellCMS\Forms\Components\Contracts;

use Closure;

interface CanDisableOptions
{
    public function disableOptionWhen(bool | Closure $callback): static;
}
