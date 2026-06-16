<?php

namespace WellCMS\Actions\Commands\Aliases;

use WellCMS\Actions\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:importer')]
class MakeImporterCommand extends Commands\MakeImporterCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:importer {name?} {--G|generate} {--F|force}';
}
