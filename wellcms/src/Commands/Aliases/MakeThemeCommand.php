<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:theme')]
class MakeThemeCommand extends Commands\MakeThemeCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:theme {panel?} {--pm=} {--F|force}';
}
