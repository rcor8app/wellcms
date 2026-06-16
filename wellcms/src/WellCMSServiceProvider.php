<?php

namespace WellCMS;

use WellCMS\Facades\WellCMS;
use WellCMS\Http\Middleware\Authenticate;
use WellCMS\Http\Middleware\DisableBladeIconComponents;
use WellCMS\Http\Middleware\DispatchServingWellCMSEvent;
use WellCMS\Http\Middleware\IdentifyTenant;
use WellCMS\Http\Middleware\SetUpPanel;
use WellCMS\Http\Responses\Auth\Contracts\EmailVerificationResponse as EmailVerificationResponseContract;
use WellCMS\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use WellCMS\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use WellCMS\Http\Responses\Auth\Contracts\PasswordResetResponse as PasswordResetResponseContract;
use WellCMS\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use WellCMS\Http\Responses\Auth\EmailVerificationResponse;
use WellCMS\Http\Responses\Auth\LoginResponse;
use WellCMS\Http\Responses\Auth\LogoutResponse;
use WellCMS\Http\Responses\Auth\PasswordResetResponse;
use WellCMS\Http\Responses\Auth\RegistrationResponse;
use WellCMS\Navigation\NavigationManager;
use WellCMS\Support\Assets\Js;
use WellCMS\Support\Assets\Theme;
use WellCMS\Support\Facades\WellCMSAsset;
use WellCMS\View\LegacyComponents;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WellCMSServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wellcms-panels')
            ->hasCommands($this->getCommands())
            ->hasRoutes('web')
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->app->scoped('wellcms', function (): WellCMSManager {
            return new WellCMSManager;
        });

        $this->app->alias('wellcms', WellCMSManager::class);

        $this->app->singleton(PanelRegistry::class, function (): PanelRegistry {
            return new PanelRegistry;
        });

        $this->app->scoped(NavigationManager::class, function (): NavigationManager {
            return new NavigationManager;
        });

        $this->app->bind(EmailVerificationResponseContract::class, EmailVerificationResponse::class);
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        $this->app->bind(PasswordResetResponseContract::class, PasswordResetResponse::class);
        $this->app->bind(RegistrationResponseContract::class, RegistrationResponse::class);

        app(Router::class)->aliasMiddleware('panel', SetUpPanel::class);
    }

    public function packageBooted(): void
    {
        Blade::components([
            LegacyComponents\Page::class => 'wellcms::page',
            LegacyComponents\Widget::class => 'wellcms::widget',
        ]);

        WellCMSAsset::register([
            Js::make('app', __DIR__ . '/../dist/index.js')->core(),
            Js::make('echo', __DIR__ . '/../dist/echo.js')->core(),
            Theme::make('app', __DIR__ . '/../dist/theme.css'),
        ], 'wellcms/wellcms');

        Livewire::addPersistentMiddleware([
            Authenticate::class,
            DisableBladeIconComponents::class,
            DispatchServingWellCMSEvent::class,
            IdentifyTenant::class,
            SetUpPanel::class,
        ]);

        WellCMS::serving(function () {
            WellCMS::setServingStatus();
        });

        if ($this->app->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/wellcms/{$file->getFilename()}"),
                ], 'wellcms-stubs');
            }
        }
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        $commands = [
            Commands\CacheComponentsCommand::class,
            Commands\ClearCachedComponentsCommand::class,
            Commands\MakeClusterCommand::class,
            Commands\MakePageCommand::class,
            Commands\MakePanelCommand::class,
            Commands\MakeRelationManagerCommand::class,
            Commands\MakeResourceCommand::class,
            Commands\MakeThemeCommand::class,
            Commands\MakeUserCommand::class,
        ];

        $aliases = [];

        foreach ($commands as $command) {
            $class = 'WellCMS\\Commands\\Aliases\\' . class_basename($command);

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
