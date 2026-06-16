<div class="fi-resource-relation-manager flex flex-col gap-y-6">
    <x-wellcms-panels::resources.tabs />

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_RELATION_MANAGER_BEFORE, scopes: $this->getRenderHookScopes()) }}

    {{ $this->table }}

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::RESOURCE_RELATION_MANAGER_AFTER, scopes: $this->getRenderHookScopes()) }}

    <x-wellcms-panels::unsaved-action-changes-alert />
</div>
