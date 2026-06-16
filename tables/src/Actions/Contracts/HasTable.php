<?php

namespace WellCMS\Tables\Actions\Contracts;

use WellCMS\Tables\Table;

interface HasTable
{
    public function table(Table $table): static;

    public function getTable(): Table;
}
