<?php

namespace WellCMS\Tables\Table\Concerns;

use WellCMS\Support\Contracts\TranslatableContentDriver;
use WellCMS\Tables\Contracts\HasTable;

trait BelongsToLivewire
{
    protected HasTable $livewire;

    public function livewire(HasTable $livewire): static
    {
        $this->livewire = $livewire;

        return $this;
    }

    public function getLivewire(): HasTable
    {
        return $this->livewire;
    }

    public function makeTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return $this->getLivewire()->makeWellCMSTranslatableContentDriver();
    }
}
