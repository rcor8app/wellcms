<?php

namespace WellCMS\Tables\Commands\Aliases;

use WellCMS\Tables\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'tables:column')]
class MakeColumnCommand extends Commands\MakeColumnCommand
{
    protected $hidden = true;

    protected $signature = 'tables:column {name} {--F|force}';
}
