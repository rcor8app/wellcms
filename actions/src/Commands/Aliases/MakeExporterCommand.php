<?php

namespace WellCMS\Actions\Commands\Aliases;

use WellCMS\Actions\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:exporter')]
class MakeExporterCommand extends Commands\MakeExporterCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:exporter {name?} {--G|generate} {--F|force}';
}
