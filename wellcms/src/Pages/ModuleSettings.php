<?php

namespace WellCMS\Pages;

use WellCMS\Support\ModuleManager;
use WellCMS\Notifications\Notification;

class ModuleSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static string $view = 'wellcms::pages.module-settings';

    protected static ?int $navigationSort = 99;

    public static function getNavigationGroup(): ?string
    {
        return __('Налаштування');
    }

    public static function getNavigationLabel(): string
    {
        return __('Модулі');
    }

    public function getTitle(): string
    {
        return __('Управління модулями');
    }

    public function getModules(): array
    {
        return ModuleManager::getAvailableModules();
    }

    public function isModuleActive(string $key): bool
    {
        return ModuleManager::isModuleActive($key);
    }

    public function toggleModule(string $key): void
    {
        if (!class_exists(\App\Models\Setting::class)) {
            Notification::make()
                ->title('Модель налаштувань не знайдена')
                ->danger()
                ->send();
            return;
        }

        $saved = \App\Models\Setting::get('active_modules');
        $active = [];
        if ($saved) {
            $active = is_array($saved) ? $saved : json_decode($saved, true);
        }

        // Fill missing defaults before toggle
        foreach (ModuleManager::getAvailableModules() as $mKey => $meta) {
            if (! isset($active[$mKey])) {
                $active[$mKey] = $meta['default'];
            }
        }

        // Toggle state
        $active[$key] = !$active[$key];

        \App\Models\Setting::set('active_modules', json_encode($active));

        Notification::make()
            ->title('Статус модуля змінено успішно')
            ->success()
            ->send();
    }
}
