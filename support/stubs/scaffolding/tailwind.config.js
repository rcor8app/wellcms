import preset from './vendor/wellcms/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/WellCMS/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wellcms/**/*.blade.php',
    ],
}
