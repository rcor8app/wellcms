@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

<header class="re-simple-header flex flex-col items-center">
    @if ($logo)
        <x-wellcms-panels::logo class="mb-4" />
    @endif

    @if (filled($heading))
        <h1
            class="re-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white"
        >
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p
            class="re-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400"
        >
            {{ $subheading }}
        </p>
    @endif
</header>
