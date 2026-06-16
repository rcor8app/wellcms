<?php

namespace WellCMS\Commands\Aliases;

use WellCMS\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:user')]
class MakeUserCommand extends Commands\MakeUserCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:user';
}
