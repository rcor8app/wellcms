<?php

namespace WellCMS\Support\Components;

use WellCMS\Support\Concerns\Configurable;
use WellCMS\Support\Concerns\EvaluatesClosures;
use WellCMS\Support\Concerns\Macroable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Tappable;

abstract class Component
{
    use Conditionable;
    use Configurable;
    use EvaluatesClosures;
    use Macroable;
    use Tappable;
}
