<?php

namespace WellCMS\GlobalSearch\Actions;

use WellCMS\Actions\StaticAction;
use WellCMS\Support\Enums\ActionSize;

class Action extends StaticAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultView(static::LINK_VIEW);

        $this->defaultSize(ActionSize::Small);
    }
}
