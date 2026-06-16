<?php

namespace WellCMS\Commands;

use WellCMS\Support\Commands\Concerns\CanGeneratePanels;
use WellCMS\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;
use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:wellcms-panel')]
class MakePanelCommand extends Command
{
    use CanGeneratePanels;
    use CanManipulateFiles;

    protected $description = 'Create a new WellCMS panel';

    protected $signature = 'make:wellcms-panel {id?} {--F|force}';

    public function handle(): int
    {
        if (! $this->generatePanel(id: $this->argument('id'), placeholder: 'app', force: $this->option('force'))) {
            return static::FAILURE;
        }

        return static::SUCCESS;
    }

    /**
     * We need to override this method as the panel provider
     * stubs are part of the support package, not panels.
     */
    protected function getDefaultStubPath(): string
    {
        $reflectionClass = new ReflectionClass($this);

        return (string) str($reflectionClass->getFileName())
            ->beforeLast('Commands')
            ->append('../../support/stubs');
    }
}
