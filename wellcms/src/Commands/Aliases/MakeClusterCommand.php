<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:cluster')]
class MakeClusterCommand extends Commands\MakeClusterCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:cluster {name?} {--panel=} {--F|force}';
}
