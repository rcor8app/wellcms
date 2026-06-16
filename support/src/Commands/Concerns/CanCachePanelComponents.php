<?php

namespace WellCMS\Support\Commands\Concerns;

use WellCMS\Commands\CacheComponentsCommand;

trait CanCachePanelComponents
{
    protected function canCachePanelComponents(): bool
    {
        return class_exists(CacheComponentsCommand::class);
    }
}
