<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:relation-manager')]
class MakeRelationManagerCommand extends Commands\MakeRelationManagerCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:relation-manager {resource?} {relationship?} {recordTitleAttribute?} {--attach} {--associate} {--soft-deletes} {--view} {--panel=} {--F|force}';
}
