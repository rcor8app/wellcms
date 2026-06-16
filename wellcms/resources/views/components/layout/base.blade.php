@props([
    'livewire' => null,
])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('wellcms-panels::layout.direction') ?? 'ltr' }}"
    @class([
        'fi min-h-screen',
        'dark' => wellcms()->hasDarkModeForced(),
    ])
>
    <head>
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::HEAD_START, scopes: $livewire?->getRenderHookScopes()) }}

        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @if ($favicon = wellcms()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        @php
            $title = trim(strip_tags(($livewire ?? null)?->getTitle() ?? ''));
            $brandName = trim(strip_tags(wellcms()->getBrandName()));
        @endphp

        <title>
            {{ filled($title) ? "{$title} - " : null }} {{ $brandName }}
        </title>

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::STYLES_BEFORE, scopes: $livewire?->getRenderHookScopes()) }}

        <style>
            [x-cloak=''],
            [x-cloak='x-cloak'],
            [x-cloak='1'] {
                display: none !important;
            }

            @media (max-width: 1023px) {
                [x-cloak='-lg'] {
                    display: none !important;
                }
            }

            @media (min-width: 1024px) {
                [x-cloak='lg'] {
                    display: none !important;
                }
            }
        </style>

        @wellcmsStyles

        {{ wellcms()->getTheme()->getHtml() }}
        {{ wellcms()->getFontHtml() }}

        <style>
            :root {
                --font-family: '{!! wellcms()->getFontFamily() !!}';
                --sidebar-width: {{ wellcms()->getSidebarWidth() }};
                --collapsed-sidebar-width: {{ wellcms()->getCollapsedSidebarWidth() }};
                --default-theme-mode: {{ wellcms()->getDefaultThemeMode()->value }};
            }
        </style>

        @stack('styles')

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::STYLES_AFTER, scopes: $livewire?->getRenderHookScopes()) }}

        @if (! wellcms()->hasDarkMode())
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        @elseif (wellcms()->hasDarkModeForced())
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        @else
            <script>
                const loadDarkMode = () => {
                    window.theme = localStorage.getItem('theme') ?? @js(wellcms()->getDefaultThemeMode()->value)

                    if (
                        window.theme === 'dark' ||
                        (window.theme === 'system' &&
                            window.matchMedia('(prefers-color-scheme: dark)')
                                .matches)
                    ) {
                        document.documentElement.classList.add('dark')
                    }
                }

                loadDarkMode()

                document.addEventListener('livewire:navigated', loadDarkMode)
            </script>
        @endif

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::HEAD_END, scopes: $livewire?->getRenderHookScopes()) }}
    </head>

    <body
        {{ $attributes
                ->merge(($livewire ?? null)?->getExtraBodyAttributes() ?? [], escape: false)
                ->class([
                    'fi-body',
                    'fi-panel-' . wellcms()->getId(),
                    'min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white',
                ]) }}
    >
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::BODY_START, scopes: $livewire?->getRenderHookScopes()) }}

        {{ $slot }}

        @livewire(WellCMS\Livewire\Notifications::class)

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::SCRIPTS_BEFORE, scopes: $livewire?->getRenderHookScopes()) }}

        @wellcmsScripts(withCore: true)

        @if (wellcms()->hasBroadcasting() && config('wellcms.broadcasting.echo'))
            <script data-navigate-once>
                window.Echo = new window.EchoFactory(@js(config('wellcms.broadcasting.echo')))

                window.dispatchEvent(new CustomEvent('EchoLoaded'))
            </script>
        @endif

        @if (wellcms()->hasDarkMode() && (! wellcms()->hasDarkModeForced()))
            <script>
                loadDarkMode()
            </script>
        @endif

        @stack('scripts')

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::SCRIPTS_AFTER, scopes: $livewire?->getRenderHookScopes()) }}

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::BODY_END, scopes: $livewire?->getRenderHookScopes()) }}
    </body>
</html>
