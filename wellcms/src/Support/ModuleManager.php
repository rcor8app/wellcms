<?php

namespace WellCMS\Support;

use Illuminate\Support\Facades\Schema;

class ModuleManager
{
    protected static ?array $activeModules = null;

    /**
     * Get all defined modules and their default status.
     */
    public static function getAvailableModules(): array
    {
        return [
            'ecommerce' => [
                'name' => 'Магазин (E-commerce)',
                'description' => 'Управління товарами, замовленнями, клієнтами та характеристиками товарів.',
                'default' => true,
            ],
            'blog' => [
                'name' => 'Контент та Блог (CMS)',
                'description' => 'Управління статтями, статичними сторінками, категоріями та меню сайту.',
                'default' => true,
            ],
            'media' => [
                'name' => 'Медіаменеджер (Media Manager)',
                'description' => 'Завантаження картинок, файлів та управління сховищем.',
                'default' => true,
            ],
            'reviews' => [
                'name' => 'Відгуки (Reviews)',
                'description' => 'Модерація та управління відгуками покупців на сайті.',
                'default' => true,
            ],
        ];
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
     * Load active modules status from DB or config.
     */
    protected static function loadActiveModules(): void
    {
        static::$activeModules = [];

        // Check if settings table exists to load dynamic status
        try {
            if (class_exists(\App\Models\Setting::class) && Schema::hasTable('settings')) {
                $saved = \App\Models\Setting::get('active_modules');
                if ($saved) {
                    static::$activeModules = is_array($saved) ? $saved : json_decode($saved, true);
                }
            }
        } catch (\Throwable $e) {
            // DB not ready or migrator running
        }

        // Fill missing modules with defaults
        foreach (static::getAvailableModules() as $key => $meta) {
            if (! isset(static::$activeModules[$key])) {
                static::$activeModules[$key] = $meta['default'];
            }
        }
    }
}
