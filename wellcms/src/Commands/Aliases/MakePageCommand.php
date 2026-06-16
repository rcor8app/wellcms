<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:page')]
class MakePageCommand extends Commands\MakePageCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:page {name?} {--R|resource=} {--T|type=} {--panel=} {--F|force}';
}
