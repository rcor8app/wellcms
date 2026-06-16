<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:panel')]
class MakePanelCommand extends Commands\MakePanelCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:panel {id?} {--F|force}';
}
