<x-wellcms-panels::page.simple>
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::AUTH_PASSWORD_RESET_RESET_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-wellcms-panels::form id="form" wire:submit="resetPassword">
        {{ $this->form }}

        <x-wellcms-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-wellcms-panels::form>

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::AUTH_PASSWORD_RESET_RESET_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-wellcms-panels::page.simple>
