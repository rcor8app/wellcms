<?php

namespace WellCMS\Infolists\Components;

use WellCMS\Support\Concerns\CanBeCopied;

class ColorEntry extends Entry
{
    use CanBeCopied;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-infolists::components.color-entry';
}
