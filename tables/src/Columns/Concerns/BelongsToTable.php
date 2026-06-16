<?php

namespace WellCMS\Tables\Columns\Concerns;

use WellCMS\Tables\Contracts\HasTable;
use WellCMS\Tables\Table;

trait BelongsToTable
{
    protected ?Table $table = null;

    public function table(?Table $table): static
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
}
