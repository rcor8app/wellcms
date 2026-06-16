<?php

namespace WellCMS\Tables;

use WellCMS\Support\Assets\AlpineComponent;
use WellCMS\Support\Facades\WellCMSAsset;
use WellCMS\Tables\Testing\TestsActions;
use WellCMS\Tables\Testing\TestsBulkActions;
use WellCMS\Tables\Testing\TestsColumns;
use WellCMS\Tables\Testing\TestsFilters;
use WellCMS\Tables\Testing\TestsRecords;
use WellCMS\Tables\Testing\TestsSummaries;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wellcms-tables')
            ->hasCommands($this->getCommands())
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        WellCMSAsset::register([
            AlpineComponent::make('table', __DIR__ . '/../dist/components/table.js'),
        ], 'wellcms/tables');

        if ($this->app->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/wellcms/{$file->getFilename()}"),
                ], 'wellcms-stubs');
            }
        }

        Testable::mixin(new TestsActions);
        Testable::mixin(new TestsBulkActions);
        Testable::mixin(new TestsColumns);
        Testable::mixin(new TestsFilters);
        Testable::mixin(new TestsRecords);
        Testable::mixin(new TestsSummaries);
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        $commands = [
            Commands\MakeColumnCommand::class,
            Commands\MakeTableCommand::class,
        ];

        $aliases = [];

        foreach ($commands as $command) {
            $class = 'WellCMS\\Tables\\Commands\\Aliases\\' . class_basename($command);

            if (! class_exists($class)) {
                continue;
            }

            $aliases[] = $class;
        }

        return [
            ...$commands,
            ...$aliases,
        ];
    }
}
