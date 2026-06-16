<?php

namespace WellCMS\Widgets;

use WellCMS\Support\Assets\AlpineComponent;
use WellCMS\Support\Facades\WellCMSAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WidgetsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wellcms-widgets')
            ->hasCommands($this->getCommands())
            ->hasViews();
    }

    public function packageBooted(): void
    {
        WellCMSAsset::register([
            AlpineComponent::make('chart', __DIR__ . '/../dist/components/chart.js'),
            AlpineComponent::make('stats-overview/stat/chart', __DIR__ . '/../dist/components/stats-overview/stat/chart.js'),
        ], 'wellcms/widgets');
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        $commands = [
            Commands\MakeWidgetCommand::class,
        ];

        $aliases = [];

        foreach ($commands as $command) {
            $class = 'WellCMS\\Widgets\\Commands\\Aliases\\' . class_basename($command);

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
