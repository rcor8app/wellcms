@if (count($tabs = $this->getCachedTabs()))
    @php
        $activeTab = strval($this->activeTab);
        $renderHookScopes = $this->getRenderHookScopes();
    @endphp

    <x-wellcms::tabs>
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_TABS_START, scopes: $renderHookScopes) }}
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_START, scopes: $renderHookScopes) }}

        @foreach ($tabs as $tabKey => $tab)
            @php
                $tabKey = strval($tabKey);
            @endphp

            <x-wellcms::tabs.item
                :active="$activeTab === $tabKey"
                :badge="$tab->getBadge()"
                :badge-color="$tab->getBadgeColor()"
                :badge-icon="$tab->getBadgeIcon()"
                :badge-icon-position="$tab->getBadgeIconPosition()"
                :icon="$tab->getIcon()"
                :icon-position="$tab->getIconPosition()"
                :wire:click="'$set(\'activeTab\', ' . (filled($tabKey) ? ('\'' . $tabKey . '\'') : 'null') . ')'"
                :attributes="$tab->getExtraAttributeBag()"
            >
                {{ $tab->getLabel() ?? $this->generateTabLabel($tabKey) }}
            </x-wellcms::tabs.item>
        @endforeach

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_TABS_END, scopes: $renderHookScopes) }}
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_END, scopes: $renderHookScopes) }}
    </x-wellcms::tabs>
@endif
