<?php

namespace WellCMS\Commands;

use WellCMS\Facades\WellCMS;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:cache-components')]
class CacheComponentsCommand extends Command
{
    protected $description = 'Cache all components';

    protected $signature = 'wellcms:cache-components';

    public function handle(): int
    {
        $this->info('Caching registered components...');

        foreach (WellCMS::getPanels() as $panel) {
            $panel->cacheComponents();
        }

        $this->info('All done!');

        return static::SUCCESS;
    }
}
