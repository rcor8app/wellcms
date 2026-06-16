<?php

namespace WellCMS\Actions;

use WellCMS\Actions\Testing\TestsActions;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ActionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wellcms-actions')
            ->hasCommands($this->getCommands())
            ->hasMigrations([
                'create_imports_table',
                'create_exports_table',
                'create_failed_import_rows_table',
            ])
            ->hasRoute('web')
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        app(Router::class)->middlewareGroup('wellcms.actions', ['web', 'auth']);
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/wellcms/{$file->getFilename()}"),
                ], 'wellcms-stubs');
            }
        }

        Testable::mixin(new TestsActions);
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        $commands = [
            Commands\MakeExporterCommand::class,
            Commands\MakeImporterCommand::class,
        ];

        $aliases = [];

        foreach ($commands as $command) {
            $class = 'WellCMS\\Actions\\Commands\\Aliases\\' . class_basename($command);

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
