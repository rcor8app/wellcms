<?php

namespace WellCMS\Tables\Filters\Concerns;

use WellCMS\Tables\Contracts\HasTable;
use WellCMS\Tables\Table;

trait BelongsToTable
{
    protected Table $table;

    public function table(Table $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): Table
    {
        return $this->table;
    }

    public function getLivewire(): HasTable
    {
        return $this->getTable()->getLivewire();
    }

    /**
     * @return array<string, mixed>
     */
    public function getState(): array
    {
        return $this->getLivewire()->getTableFilterState($this->getName()) ?? [];
    }
}
