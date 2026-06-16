<?php

namespace WellCMS\Pages\Concerns;

use WellCMS\Support\Enums\MaxWidth;

trait HasMaxWidth
{
    protected ?string $maxWidth = null;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return $this->maxWidth;
    }
}
