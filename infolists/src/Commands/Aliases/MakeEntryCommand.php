<?php

namespace WellCMS\Infolists\Commands\Aliases;

use WellCMS\Infolists\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'infolists:entry')]
class MakeEntryCommand extends Commands\MakeEntryCommand
{
    protected $hidden = true;

    protected $signature = 'infolists:entry {name} {--F|force}';
}
