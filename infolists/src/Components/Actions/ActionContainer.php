<?php

namespace WellCMS\Infolists\Components\Actions;

use WellCMS\Infolists\Components\Component;

class ActionContainer extends Component
{
    protected string $view = 'wellcms-infolists::components.actions.action-container';

    final public function __construct(Action $action)
    {
        $this->action($action);
    }

    public static function make(Action $action): static
    {
        $static = app(static::class, ['action' => $action]);
        $static->configure();

        return $static;
    }

    public function getKey(): string
    {
        return parent::getKey() ?? "{$this->getStatePath()}.{$this->getAction()->getName()}Action";
    }

    public function isHidden(): bool
    {
        return $this->getAction()->isHidden();
    }
}
