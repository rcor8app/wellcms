<x-dynamic-component
    :component="static::isSimple() ? 'wellcms-panels::page.simple' : 'wellcms-panels::page'"
>
    <x-wellcms-panels::form id="form" wire:submit="save">
        {{ $this->form }}

        <x-wellcms-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-wellcms-panels::form>
</x-dynamic-component>
