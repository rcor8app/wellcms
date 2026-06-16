<?php

namespace WellCMS\Support\Commands\Aliases;

use WellCMS\Support\Commands;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:issue')]
class MakeIssueCommand extends Commands\MakeIssueCommand
{
    protected $hidden = true;

    protected $signature = 'wellcms:issue';
}
