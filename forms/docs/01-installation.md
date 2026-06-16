---
title: Installation
---

**The Form Builder package is pre-installed with the [Panel Builder](../panels/installation).** This guide is for using the Form Builder in a custom TALL Stack application (Tailwind, Alpine, Livewire, Laravel).

## Requirements

WellCMS requires the following to run:

- PHP 8.1+
- Laravel v10.0+
- Livewire v3.0+
- Tailwind v3.0+ [(Using Tailwind v4?)](#installing-tailwind-css)

## Installation

Require the Form Builder package using Composer:

```bash
composer require wellcms/forms:"^3.3" -W
```

## New Laravel projects

To quickly get started with WellCMS in a new Laravel project, run the following commands to install [Livewire](https://livewire.laravel.com), [Alpine.js](https://alpinejs.dev), and [Tailwind CSS](https://tailwindcss.com):

> Since these commands will overwrite existing files in your application, only run this in a new Laravel project!

```bash
php artisan wellcms:install --scaffold --forms

npm install

npm run dev
```

## Existing Laravel projects

Run the following command to install the Form Builder assets:

```bash
php artisan wellcms:install --forms
```

### Installing Tailwind CSS

> WellCMS uses Tailwind CSS v3 for styling. If your project uses Tailwind CSS v4, you will unfortunately need to downgrade it to v3 to use WellCMS. WellCMS v3 can't support Tailwind CSS v4 since it introduces breaking changes. WellCMS v4 will support Tailwind CSS v4.

Run the following command to install Tailwind CSS with the Tailwind Forms and Typography plugins:

```bash
npm install tailwindcss@3 @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
```

Create a new `tailwind.config.js` file and add the WellCMS `preset` *(includes the WellCMS color scheme and the required Tailwind plugins)*:

```js
import preset from './vendor/wellcms/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/WellCMS/**/*.php',
        './resources/views/wellcms/**/*.blade.php',
        './vendor/wellcms/**/*.blade.php',
    ],
}
```

### Configuring styles

Add Tailwind's CSS layers to your `resources/css/app.css`:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
@tailwind variants;
```

Create a `postcss.config.js` file in the root of your project and register Tailwind CSS, PostCSS Nesting and Autoprefixer as plugins:

```js
export default {
    plugins: {
        'tailwindcss/nesting': 'postcss-nesting',
        tailwindcss: {},
        autoprefixer: {},
    },
}
```

### Automatically refreshing the browser
You may also want to update your `vite.config.js` file to refresh the page automatically when Livewire components are updated:

```js
import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
})
```

### Compiling assets

Compile your new CSS and Javascript assets using `npm run dev`.

### Configuring your layout

Create a new `resources/views/components/layouts/app.blade.php` layout file for Livewire components:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @wellcmsStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        {{ $slot }}

        @wellcmsScripts
        @vite('resources/js/app.js')
    </body>
</html>
```

## Publishing configuration

You can publish the package configuration using the following command (optional):

```bash
php artisan vendor:publish --tag=wellcms-config
```

## Upgrading

> Upgrading from WellCMS v2? Please review the [upgrade guide](upgrade-guide).

WellCMS automatically upgrades to the latest non-breaking version when you run `composer update`. After any updates, all Laravel caches need to be cleared, and frontend assets need to be republished. You can do this all at once using the `wellcms:upgrade` command, which should have been added to your `composer.json` file when you ran `wellcms:install` the first time:

```json
"post-autoload-dump": [
    // ...
    "@php artisan wellcms:upgrade"
],
```

Please note that `wellcms:upgrade` does not actually handle the update process, as Composer does that already. If you're upgrading manually without a `post-autoload-dump` hook, you can run the command yourself:

```bash
composer update

php artisan wellcms:upgrade
```
