@props([
    'navigation',
])

<div
    {{ $attributes->class(['re-page-sub-navigation-sidebar-ctn hidden w-72 flex-col md:flex']) }}
>
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SIDEBAR_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <ul
        wire:ignore
        class="re-page-sub-navigation-sidebar flex flex-col gap-y-7"
    >
        @foreach ($navigation as $navigationGroup)
            <x-wellcms-panels::sidebar.group
                :active="$navigationGroup->isActive()"
                :collapsible="$navigationGroup->isCollapsible()"
                :icon="$navigationGroup->getIcon()"
                :items="$navigationGroup->getItems()"
                :label="$navigationGroup->getLabel()"
                :sidebar-collapsible="false"
                sub-navigation
                :attributes="\WellCMS\Support\prepare_inherited_attributes($navigationGroup->getExtraSidebarAttributeBag())"
            />
        @endforeach
    </ul>

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SIDEBAR_AFTER, scopes: $this->getRenderHookScopes()) }}
</div>
