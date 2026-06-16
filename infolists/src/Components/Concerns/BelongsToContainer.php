<?php

namespace WellCMS\Infolists\Components\Concerns;

use WellCMS\Infolists\ComponentContainer;
use WellCMS\Infolists\Infolist;
use Livewire\Component;

trait BelongsToContainer
{
    protected ComponentContainer $container;

    public function container(ComponentContainer $container): static
    {
        $this->container = $container;

        return $this;
    }

    public function getContainer(): ComponentContainer
    {
        return $this->container;
    }

    public function getInfolist(): Infolist
    {
        return $this->getContainer()->getInfolist();
    }

    public function getLivewire(): ?Component
    {
        return $this->getContainer()->getLivewire();
    }
}
