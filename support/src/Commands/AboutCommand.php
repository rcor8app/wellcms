<?php

namespace WellCMS\Support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:about')]
class AboutCommand extends Command
{
    protected $signature = 'wellcms:about';

    protected $description = 'Display basic information about WellCMS packages that are installed';

    public function handle(): void
    {
        $this->call('about', [
            '--only' => 'wellcms',
        ]);
    }
}
