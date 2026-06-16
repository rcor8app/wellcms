<?php

namespace WellCMS\Notifications\Concerns;

use Closure;
use WellCMS\Notifications\Actions\Action;
use WellCMS\Notifications\Actions\ActionGroup;
use Illuminate\Support\Arr;

trait HasActions
{
    /**
     * @var array<Action | ActionGroup> | ActionGroup | Closure
     */
    protected array | ActionGroup | Closure $actions = [];

    /**
     * @param  array<Action | ActionGroup> | ActionGroup | Closure  $actions
     */
    public function actions(array | ActionGroup | Closure $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getActions(): array
    {
        return Arr::wrap($this->evaluate($this->actions));
    }
}
