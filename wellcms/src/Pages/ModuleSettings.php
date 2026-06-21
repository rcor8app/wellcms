<?php

namespace WellCMS\Pages;

use WellCMS\Support\ModuleManager;
use WellCMS\Notifications\Notification;
use Illuminate\Support\Str;

class ModuleSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static string $view = 'wellcms::pages.module-settings';

    protected static ?int $navigationSort = 99;

    public bool $showCreateModal = false;
    public string $newModuleName = '';
    public string $newModuleDescription = '';

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
                $active[$mKey] = $meta['default'] ?? true;
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

    public function createModule(): void
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return;
        }

        $key = Str::slug($this->newModuleName);

        if (array_key_exists($key, ModuleManager::getAvailableModules())) {
            Notification::make()
                ->title('Модуль з такою назвою вже існує')
                ->danger()
                ->send();
            return;
        }

        $saved = \App\Models\Setting::get('custom_modules');
        $custom = [];
        if ($saved) {
            $custom = is_array($saved) ? $saved : json_decode($saved, true);
        }

        $custom[$key] = [
            'name' => $this->newModuleName,
            'description' => $this->newModuleDescription,
            'default' => true,
            'can_delete' => true,
        ];

        \App\Models\Setting::set('custom_modules', json_encode($custom));

        $this->showCreateModal = false;
        $this->newModuleName = '';
        $this->newModuleDescription = '';

        Notification::make()
            ->title('Модуль успішно створено')
            ->success()
            ->send();
    }

    public function deleteModule(string $key): void
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return;
        }

        $saved = \App\Models\Setting::get('custom_modules');
        $custom = [];
        if ($saved) {
            $custom = is_array($saved) ? $saved : json_decode($saved, true);
        }

        if (isset($custom[$key])) {
            unset($custom[$key]);
            \App\Models\Setting::set('custom_modules', json_encode($custom));
        }

        // Also clean active status
        $savedActive = \App\Models\Setting::get('active_modules');
        $active = [];
        if ($savedActive) {
            $active = is_array($savedActive) ? $savedActive : json_decode($savedActive, true);
        }
        if (isset($active[$key])) {
            unset($active[$key]);
            \App\Models\Setting::set('active_modules', json_encode($active));
        }

        Notification::make()
            ->title('Модуль успішно видалено')
            ->success()
            ->send();
    }
}
