<x-wellcms-panels::page.simple>
    <x-wellcms-panels::form id="form" wire:submit="register">
        {{ $this->form }}

        <x-wellcms-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-wellcms-panels::form>
</x-wellcms-panels::page.simple>
