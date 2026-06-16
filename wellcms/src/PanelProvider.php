<?php

namespace WellCMS;

use WellCMS\Facades\WellCMS;
use Illuminate\Support\ServiceProvider;

abstract class PanelProvider extends ServiceProvider
{
    abstract public function panel(Panel $panel): Panel;

    public function register(): void
    {
        WellCMS::registerPanel(
            fn (): Panel => $this->panel(Panel::make()),
        );
    }
}
