<?php

namespace WellCMS\Support;

use Illuminate\Support\Facades\Schema;

class ModuleManager
{
    protected static ?array $activeModules = null;
    protected static ?array $customModules = null;

    /**
     * Get all built-in modules.
     */
    public static function getBuiltInModules(): array
    {
        return [
            'ecommerce' => [
                'name' => 'Магазин (E-commerce)',
                'description' => 'Управління товарами, замовленнями, клієнтами та характеристиками товарів.',
                'default' => true,
                'can_delete' => false,
            ],
            'blog' => [
                'name' => 'Контент та Блог (CMS)',
                'description' => 'Управління статтями, статичними сторінками, категоріями та меню сайту.',
                'default' => true,
                'can_delete' => false,
            ],
            'media' => [
                'name' => 'Медіаменеджер (Media Manager)',
                'description' => 'Завантаження картинок, файлів та управління сховищем.',
                'default' => true,
                'can_delete' => false,
            ],
            'reviews' => [
                'name' => 'Відгуки (Reviews)',
                'description' => 'Модерація та управління відгуками покупців на сайті.',
                'default' => true,
                'can_delete' => false,
            ],
        ];
    }

    /**
     * Get all modules (built-in + custom).
     */
    public static function getAvailableModules(): array
    {
        if (static::$customModules === null) {
            static::loadCustomModules();
        }

        return array_merge(static::getBuiltInModules(), static::$customModules);
    }

    /**
     * Check if a specific module is active.
     */
    public static function isModuleActive(string $module): bool
    {
        if (static::$activeModules === null) {
            static::loadActiveModules();
        }

        return static::$activeModules[$module] ?? true;
    }

    /**
     * Load custom modules from settings database.
     */
    protected static function loadCustomModules(): void
    {
        static::$customModules = [];
        try {
            if (class_exists(\App\Models\Setting::class) && Schema::hasTable('settings')) {
                $saved = \App\Models\Setting::get('custom_modules');
                if ($saved) {
                    static::$customModules = is_array($saved) ? $saved : json_decode($saved, true);
                }
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Load active modules status from DB.
     */
    protected static function loadActiveModules(): void
    {
        static::$activeModules = [];

        try {
            if (class_exists(\App\Models\Setting::class) && Schema::hasTable('settings')) {
                $saved = \App\Models\Setting::get('active_modules');
                if ($saved) {
                    static::$activeModules = is_array($saved) ? $saved : json_decode($saved, true);
                }
            }
        } catch (\Throwable $e) {}

        // Fill missing modules with defaults
        foreach (static::getAvailableModules() as $key => $meta) {
            if (! isset(static::$activeModules[$key])) {
                static::$activeModules[$key] = $meta['default'] ?? true;
            }
        }
    }
}
