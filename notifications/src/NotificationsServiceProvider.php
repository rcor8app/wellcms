<?php

namespace WellCMS\Notifications;

use WellCMS\Notifications\Livewire\DatabaseNotifications;
use WellCMS\Notifications\Livewire\Notifications;
use WellCMS\Notifications\Testing\TestsNotifications;
use WellCMS\Support\Assets\Js;
use WellCMS\Support\Facades\WellCMSAsset;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use function Livewire\on;
use function Livewire\store;

class NotificationsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wellcms-notifications')
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        WellCMSAsset::register([
            Js::make('notifications', __DIR__ . '/../dist/index.js'),
        ], 'wellcms/notifications');

        Livewire::component('database-notifications', DatabaseNotifications::class);

        Livewire::component('notifications', Notifications::class);

        on('dehydrate', function (Component $component) {
            if (! Livewire::isLivewireRequest()) {
                return;
            }

            if (store($component)->has('redirect')) {
                return;
            }

            $notifications = session()->get('wellcms.notifications') ?? [];
            if (count($notifications) <= 0) {
                return;
            }

            foreach ($notifications as $notification) {
                $component->dispatch('notificationSent', notification: $notification);
            }

            session()->forget('wellcms.notifications');
        });

        Testable::mixin(new TestsNotifications);
    }
}
