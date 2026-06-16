<?php

namespace WellCMS\View\LegacyComponents;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Page extends Component
{
    public function render(): View
    {
        return view('wellcms-panels::components.page.index');
    }
}
