<?php

namespace WellCMS\Commands;

use WellCMS\Facades\WellCMS;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:clear-cached-components')]
class ClearCachedComponentsCommand extends Command
{
    protected $description = 'Clear all cached components';

    protected $signature = 'wellcms:clear-cached-components';

    public function handle(): int
    {
        $this->info('Clearing cached components...');

        foreach (WellCMS::getPanels() as $panel) {
            $panel->clearCachedComponents();
        }

        $this->info('All done!');

        return static::SUCCESS;
    }
}
