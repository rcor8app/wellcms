@php
    use WellCMS\Support\Enums\MaxWidth;

    $navigation = wellcms()->getNavigation();
    $livewire ??= null;
@endphp

<x-wellcms-panels::layout.base :livewire="$livewire">
    {{-- The sidebar is after the page content in the markup to fix issues with page content overlapping dropdown content from the sidebar. --}}
    <div
        class="re-layout flex min-h-screen w-full flex-row-reverse overflow-x-clip"
    >
        <div
            @if (wellcms()->isSidebarCollapsibleOnDesktop())
                x-data="{}"
                x-bind:class="{
                    're-main-ctn-sidebar-open': $store.sidebar.isOpen,
                }"
                x-bind:style="'display: flex; opacity:1;'" {{-- Mimics `x-cloak`, as using `x-cloak` causes visual issues with chart widgets --}}
            @elseif (wellcms()->isSidebarFullyCollapsibleOnDesktop())
                x-data="{}"
                x-bind:class="{
                    're-main-ctn-sidebar-open': $store.sidebar.isOpen,
                }"
                x-bind:style="'display: flex; opacity:1;'" {{-- Mimics `x-cloak`, as using `x-cloak` causes visual issues with chart widgets --}}
            @elseif (! (wellcms()->isSidebarCollapsibleOnDesktop() || wellcms()->isSidebarFullyCollapsibleOnDesktop() || wellcms()->hasTopNavigation() || (! wellcms()->hasNavigation())))
                x-data="{}"
                x-bind:style="'display: flex; opacity:1;'" {{-- Mimics `x-cloak`, as using `x-cloak` causes visual issues with chart widgets --}}
            @endif
            @class([
                're-main-ctn w-screen flex-1 flex-col',
                'h-full opacity-0 transition-all' => wellcms()->isSidebarCollapsibleOnDesktop() || wellcms()->isSidebarFullyCollapsibleOnDesktop(),
                'opacity-0' => ! (wellcms()->isSidebarCollapsibleOnDesktop() || wellcms()->isSidebarFullyCollapsibleOnDesktop() || wellcms()->hasTopNavigation() || (! wellcms()->hasNavigation())),
                'flex' => wellcms()->hasTopNavigation() || (! wellcms()->hasNavigation()),
            ])
        >
            @if (wellcms()->hasTopbar())
                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TOPBAR_BEFORE, scopes: $livewire?->getRenderHookScopes()) }}

                <x-wellcms-panels::topbar :navigation="$navigation" />

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TOPBAR_AFTER, scopes: $livewire?->getRenderHookScopes()) }}
            @endif

            {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::CONTENT_BEFORE, scopes: $livewire?->getRenderHookScopes()) }}

            <main
                @class([
                    're-main mx-auto h-full w-full px-4 md:px-6 lg:px-8',
                    match ($maxContentWidth ??= (wellcms()->getMaxContentWidth() ?? MaxWidth::SevenExtraLarge)) {
                        MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                        MaxWidth::Small, 'sm' => 'max-w-sm',
                        MaxWidth::Medium, 'md' => 'max-w-md',
                        MaxWidth::Large, 'lg' => 'max-w-lg',
                        MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                        MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                        MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                        MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                        MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                        MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                        MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                        MaxWidth::Full, 'full' => 'max-w-full',
                        MaxWidth::MinContent, 'min' => 'max-w-min',
                        MaxWidth::MaxContent, 'max' => 'max-w-max',
                        MaxWidth::FitContent, 'fit' => 'max-w-fit',
                        MaxWidth::Prose, 'prose' => 'max-w-prose',
                        MaxWidth::ScreenSmall, 'screen-sm' => 'max-w-screen-sm',
                        MaxWidth::ScreenMedium, 'screen-md' => 'max-w-screen-md',
                        MaxWidth::ScreenLarge, 'screen-lg' => 'max-w-screen-lg',
                        MaxWidth::ScreenExtraLarge, 'screen-xl' => 'max-w-screen-xl',
                        MaxWidth::ScreenTwoExtraLarge, 'screen-2xl' => 'max-w-screen-2xl',
                        default => $maxContentWidth,
                    },
                ])
            >
                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::CONTENT_START, scopes: $livewire?->getRenderHookScopes()) }}

                {{ $slot }}

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::CONTENT_END, scopes: $livewire?->getRenderHookScopes()) }}
            </main>

            {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::CONTENT_AFTER, scopes: $livewire?->getRenderHookScopes()) }}

            {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::FOOTER, scopes: $livewire?->getRenderHookScopes()) }}
        </div>

        @if (wellcms()->hasNavigation())
            <div
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                x-transition.opacity.300ms
                class="re-sidebar-close-overlay fixed inset-0 z-30 bg-gray-950/50 transition duration-500 dark:bg-gray-950/75 lg:hidden"
            ></div>

            <x-wellcms-panels::sidebar
                :navigation="$navigation"
                class="re-main-sidebar"
            />

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => {
                        let activeSidebarItem = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-item.fi-active',
                        )

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            activeSidebarItem = document.querySelector(
                                '.fi-main-sidebar .fi-sidebar-group.fi-active',
                            )
                        }

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            return
                        }

                        const sidebarWrapper = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-nav',
                        )

                        if (!sidebarWrapper) {
                            return
                        }

                        sidebarWrapper.scrollTo(
                            0,
                            activeSidebarItem.offsetTop -
                                window.innerHeight / 2,
                        )
                    }, 10)
                })
            </script>
        @endif
    </div>
</x-wellcms-panels::layout.base>
