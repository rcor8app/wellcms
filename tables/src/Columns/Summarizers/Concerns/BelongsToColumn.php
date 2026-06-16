<?php

namespace WellCMS\Tables\Columns\Summarizers\Concerns;

use WellCMS\Tables\Columns\Column;
use WellCMS\Tables\Contracts\HasTable;
use WellCMS\Tables\Table;

trait BelongsToColumn
{
    protected Column $column;

    public function column(Column $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function getColumn(): Column
    {
        return $this->column;
    }

    public function getTable(): Table
    {
        return $this->getColumn()->getTable();
    }

    public function getLivewire(): HasTable
    {
        return $this->getTable()->getLivewire();
    }
}
