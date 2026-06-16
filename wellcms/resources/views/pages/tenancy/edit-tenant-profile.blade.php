<x-wellcms-panels::page>
    <x-wellcms-panels::form id="form" wire:submit="save">
        {{ $this->form }}

        <x-wellcms-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-wellcms-panels::form>
</x-wellcms-panels::page>
