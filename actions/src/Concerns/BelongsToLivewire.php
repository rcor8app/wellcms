<?php

namespace WellCMS\Actions\Concerns;

use Exception;
use WellCMS\Actions\Contracts\HasLivewire;
use Livewire\Component;

trait BelongsToLivewire
{
    protected Component $livewire;

    public function livewire(Component $livewire): static
    {
        $this->livewire = $livewire;

        return $this;
    }

    public function getLivewire(): object
    {
        if (isset($this->livewire)) {
            return $this->livewire;
        }

        $group = $this->getGroup();

        if (! ($group instanceof HasLivewire)) {
            throw new Exception('This action does not belong to a Livewire component.');
        }

        return $group->getLivewire();
    }
}
