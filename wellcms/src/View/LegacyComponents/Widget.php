<?php

namespace WellCMS\View\LegacyComponents;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Widget extends Component
{
    public function render(): View
    {
        return view('wellcms-widgets::components.widget');
    }
}
