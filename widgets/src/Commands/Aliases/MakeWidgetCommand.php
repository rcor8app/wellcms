<?php

namespace WellCMS\Widgets\Commands\Aliases;

use WellCMS\Widgets\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:widget')]
class MakeWidgetCommand extends Commands\MakeWidgetCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:widget {name?} {--R|resource=} {--C|chart} {--T|table} {--S|stats-overview} {--panel=} {--F|force}';
}
