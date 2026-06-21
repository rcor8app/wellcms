@props([
    'navigation',
])

<div
    {{
        $attributes->class([
            're-topbar sticky top-0 z-20 overflow-x-clip',
            're-topbar-with-navigation' => wellcms()->hasTopNavigation(),
        ])
    }}
>
    <nav
        class="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:px-6 lg:px-8"
    >
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TOPBAR_START) }}

        @if (wellcms()->hasNavigation())
            <x-wellcms::icon-button
                color="gray"
                icon="heroicon-o-bars-3"
                icon-alias="panels::topbar.open-sidebar-button"
                icon-size="lg"
                :label="__('wellcms-panels::layout.actions.sidebar.expand.label')"
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.open()"
                x-show="! $store.sidebar.isOpen"
                @class([
                    're-topbar-open-sidebar-btn',
                    'lg:hidden' => (! wellcms()->isSidebarFullyCollapsibleOnDesktop()) || wellcms()->isSidebarCollapsibleOnDesktop(),
                ])
            />

            <x-wellcms::icon-button
                color="gray"
                icon="heroicon-o-x-mark"
                icon-alias="panels::topbar.close-sidebar-button"
                icon-size="lg"
                :label="__('wellcms-panels::layout.actions.sidebar.collapse.label')"
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                class="re-topbar-close-sidebar-btn lg:hidden"
            />
        @endif

        @if (wellcms()->hasTopNavigation() || (! wellcms()->hasNavigation()))
            <div class="me-6 hidden lg:flex">
                @if ($homeUrl = wellcms()->getHomeUrl())
                    <a {{ \WellCMS\Support\generate_href_html($homeUrl) }}>
                        <x-wellcms-panels::logo />
                    </a>
                @else
                    <x-wellcms-panels::logo />
                @endif
            </div>

            @if (wellcms()->hasTenancy() && wellcms()->hasTenantMenu())
                <x-wellcms-panels::tenant-menu class="hidden lg:block" />
            @endif

            @if (wellcms()->hasNavigation())
                <ul class="me-4 hidden items-center gap-x-4 lg:flex">
                    @foreach ($navigation as $group)
                        @if ($groupLabel = $group->getLabel())
                            <x-wellcms::dropdown
                                placement="bottom-start"
                                teleport
                                :attributes="\WellCMS\Support\prepare_inherited_attributes($group->getExtraTopbarAttributeBag())"
                            >
                                <x-slot name="trigger">
                                    <x-wellcms-panels::topbar.item
                                        :active="$group->isActive()"
                                        :icon="$group->getIcon()"
                                    >
                                        {{ $groupLabel }}
                                    </x-wellcms-panels::topbar.item>
                                </x-slot>

                                @php
                                    $lists = [];

                                    foreach ($group->getItems() as $item) {
                                        if ($childItems = $item->getChildItems()) {
                                            $lists[] = [
                                                $item,
                                                ...$childItems,
                                            ];
                                            $lists[] = [];

                                            continue;
                                        }

                                        if (empty($lists)) {
                                            $lists[] = [$item];

                                            continue;
                                        }

                                        $lists[count($lists) - 1][] = $item;
                                    }

                                    if (empty($lists[count($lists) - 1])) {
                                        array_pop($lists);
                                    }
                                @endphp

                                @foreach ($lists as $list)
                                    <x-wellcms::dropdown.list>
                                        @foreach ($list as $item)
                                            @php
                                                $itemIsActive = $item->isActive();
                                            @endphp

                                            <x-wellcms::dropdown.list.item
                                                :badge="$item->getBadge()"
                                                :badge-color="$item->getBadgeColor()"
                                                :badge-tooltip="$item->getBadgeTooltip()"
                                                :color="$itemIsActive ? 'primary' : 'gray'"
                                                :href="$item->getUrl()"
                                                :icon="$itemIsActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon()"
                                                tag="a"
                                                :target="$item->shouldOpenUrlInNewTab() ? '_blank' : null"
                                            >
                                                {{ $item->getLabel() }}
                                            </x-wellcms::dropdown.list.item>
                                        @endforeach
                                    </x-wellcms::dropdown.list>
                                @endforeach
                            </x-wellcms::dropdown>
                        @else
                            @foreach ($group->getItems() as $item)
                                <x-wellcms-panels::topbar.item
                                    :active="$item->isActive()"
                                    :active-icon="$item->getActiveIcon()"
                                    :badge="$item->getBadge()"
                                    :badge-color="$item->getBadgeColor()"
                                    :badge-tooltip="$item->getBadgeTooltip()"
                                    :icon="$item->getIcon()"
                                    :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                                    :url="$item->getUrl()"
                                >
                                    {{ $item->getLabel() }}
                                </x-wellcms-panels::topbar.item>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif

        <div
            @if (wellcms()->hasTenancy())
                x-persist="topbar.end.panel-{{ wellcms()->getId() }}.tenant-{{ wellcms()->getTenant()?->getKey() }}"
            @else
                x-persist="topbar.end.panel-{{ wellcms()->getId() }}"
            @endif
            class="ms-auto flex items-center gap-x-4"
        >
            {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE) }}

            @if (wellcms()->isGlobalSearchEnabled())
                @livewire(WellCMS\Livewire\GlobalSearch::class)
            @endif

            {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER) }}

            @if (wellcms()->auth()->check())
                @if (wellcms()->hasDatabaseNotifications())
                    @livewire(WellCMS\Livewire\DatabaseNotifications::class, [
                        'lazy' => wellcms()->hasLazyLoadedDatabaseNotifications(),
                    ])
                @endif

                <x-wellcms-panels::user-menu />
            @endif
        </div>

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TOPBAR_END) }}
    </nav>
</div>
