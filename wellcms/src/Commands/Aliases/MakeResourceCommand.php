<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:resource')]
class MakeResourceCommand extends Commands\MakeResourceCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:resource {name?} {--model-namespace=} {--soft-deletes} {--view} {--G|generate} {--S|simple} {--panel=} {--model} {--migration} {--factory} {--F|force}';
}
