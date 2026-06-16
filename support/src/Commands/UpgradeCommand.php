<?php

namespace WellCMS\Support\Commands;

use WellCMS\Support\Events\WellCMSUpgraded;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:upgrade')]
class UpgradeCommand extends Command
{
    protected $description = 'Upgrade WellCMS to the latest version';

    protected $signature = 'wellcms:upgrade';

    public function handle(): int
    {
        foreach ([
            AssetsCommand::class,
            'config:clear',
            'route:clear',
            'view:clear',
        ] as $command) {
            $this->call($command);
        }

        WellCMSUpgraded::dispatch();

        $this->components->info('Successfully upgraded!');

        return static::SUCCESS;
    }
}
