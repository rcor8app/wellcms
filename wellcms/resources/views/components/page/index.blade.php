@props([
    'fullHeight' => false,
])

@php
    use WellCMS\Pages\SubNavigationPosition;

    $subNavigation = $this->getCachedSubNavigation();
    $subNavigationPosition = $this->getSubNavigationPosition();
    $widgetData = $this->getWidgetData();
@endphp

<div
    {{
        $attributes->class([
            're-page',
            'h-full' => $fullHeight,
        ])
    }}
>
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <section
        @class([
            'flex flex-col gap-y-8 py-8',
            'h-full' => $fullHeight,
        ])
    >
        @if ($header = $this->getHeader())
            {{ $header }}
        @elseif ($heading = $this->getHeading())
            @php
                $subheading = $this->getSubheading();
            @endphp

            <x-wellcms-panels::header
                :actions="$this->getCachedHeaderActions()"
                :breadcrumbs="wellcms()->hasBreadcrumbs() ? $this->getBreadcrumbs() : []"
                :heading="$heading"
                :subheading="$subheading"
            >
                @if ($heading instanceof \Illuminate\Contracts\Support\Htmlable)
                    <x-slot name="heading">
                        {{ $heading }}
                    </x-slot>
                @endif

                @if ($subheading instanceof \Illuminate\Contracts\Support\Htmlable)
                    <x-slot name="subheading">
                        {{ $subheading }}
                    </x-slot>
                @endif
            </x-wellcms-panels::header>
        @endif

        <div
            @class([
                'flex flex-col gap-8' => $subNavigation,
                match ($subNavigationPosition) {
                    SubNavigationPosition::Start, SubNavigationPosition::End => 'md:flex-row md:items-start',
                    default => null,
                } => $subNavigation,
                'h-full' => $fullHeight,
            ])
        >
            @if ($subNavigation)
                <div class="contents md:hidden">
                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SELECT_BEFORE, scopes: $this->getRenderHookScopes()) }}
                </div>

                <x-wellcms-panels::page.sub-navigation.select
                    :navigation="$subNavigation"
                />

                <div class="contents md:hidden">
                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SELECT_AFTER, scopes: $this->getRenderHookScopes()) }}
                </div>

                @if ($subNavigationPosition === SubNavigationPosition::Start)
                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_START_BEFORE, scopes: $this->getRenderHookScopes()) }}

                    <x-wellcms-panels::page.sub-navigation.sidebar
                        :navigation="$subNavigation"
                    />

                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_START_AFTER, scopes: $this->getRenderHookScopes()) }}
                @endif

                @if ($subNavigationPosition === SubNavigationPosition::Top)
                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_TOP_BEFORE, scopes: $this->getRenderHookScopes()) }}

                    <x-wellcms-panels::page.sub-navigation.tabs
                        :navigation="$subNavigation"
                    />

                    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_TOP_AFTER, scopes: $this->getRenderHookScopes()) }}
                @endif
            @endif

            <div
                @class([
                    'grid flex-1 auto-cols-fr gap-y-8',
                    'h-full' => $fullHeight,
                ])
            >
                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_HEADER_WIDGETS_BEFORE, scopes: $this->getRenderHookScopes()) }}

                @if ($headerWidgets = $this->getVisibleHeaderWidgets())
                    <x-wellcms-widgets::widgets
                        :columns="$this->getHeaderWidgetsColumns()"
                        :data="$widgetData"
                        :widgets="$headerWidgets"
                        class="re-page-header-widgets"
                    />
                @endif

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER, scopes: $this->getRenderHookScopes()) }}

                {{ $slot }}

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_FOOTER_WIDGETS_BEFORE, scopes: $this->getRenderHookScopes()) }}

                @if ($footerWidgets = $this->getVisibleFooterWidgets())
                    <x-wellcms-widgets::widgets
                        :columns="$this->getFooterWidgetsColumns()"
                        :data="$widgetData"
                        :widgets="$footerWidgets"
                        class="re-page-footer-widgets"
                    />
                @endif

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_FOOTER_WIDGETS_AFTER, scopes: $this->getRenderHookScopes()) }}
            </div>

            @if ($subNavigation && $subNavigationPosition === SubNavigationPosition::End)
                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_END_BEFORE, scopes: $this->getRenderHookScopes()) }}

                <x-wellcms-panels::page.sub-navigation.sidebar
                    :navigation="$subNavigation"
                />

                {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_END_AFTER, scopes: $this->getRenderHookScopes()) }}
            @endif
        </div>

        @if ($footer = $this->getFooter())
            {{ $footer }}
        @endif
    </section>

    @if (! ($this instanceof \WellCMS\Tables\Contracts\HasTable))
        <x-wellcms-actions::modals />
    @elseif ($this->isTableLoaded() && filled($this->defaultTableAction))
        <div
            wire:init="mountTableAction(@js($this->defaultTableAction), @if (filled($this->defaultTableActionRecord)) @js($this->defaultTableActionRecord) @else {{ 'null' }} @endif @if (filled($this->defaultTableActionArguments)) , @js($this->defaultTableActionArguments) @endif)"
        ></div>
    @endif

    @if (filled($this->defaultAction))
        <div
            wire:init="mountAction(@js($this->defaultAction) @if (filled($this->defaultActionArguments)) , @js($this->defaultActionArguments) @endif)"
        ></div>
    @endif

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_END, scopes: $this->getRenderHookScopes()) }}

    <x-wellcms-panels::unsaved-action-changes-alert />
</div>
