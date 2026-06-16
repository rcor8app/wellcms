@php
    $debounce = wellcms()->getGlobalSearchDebounce();
    $keyBindings = wellcms()->getGlobalSearchKeyBindings();
    $suffix = wellcms()->getGlobalSearchFieldSuffix();
@endphp

<div
    x-id="['input']"
    {{ $attributes->class(['fi-global-search-field']) }}
>
    <label x-bind:for="$id('input')" class="sr-only">
        {{ __('wellcms-panels::global-search.field.label') }}
    </label>

    <x-wellcms::input.wrapper
        prefix-icon="heroicon-m-magnifying-glass"
        prefix-icon-alias="panels::global-search.field"
        inline-prefix
        :suffix="$suffix"
        inline-suffix
        wire:target="search"
    >
        <x-wellcms::input
            autocomplete="off"
            inline-prefix
            maxlength="1000"
            :placeholder="__('wellcms-panels::global-search.field.placeholder')"
            type="search"
            wire:key="global-search.field.input"
            x-bind:id="$id('input')"
            x-on:keydown.down.prevent.stop="$dispatch('focus-first-global-search-result')"
            x-data="{}"
            :attributes="
                \WellCMS\Support\prepare_inherited_attributes(
                    new \Illuminate\View\ComponentAttributeBag([
                        'wire:model.live.debounce.' . $debounce => 'search',
                        'x-mousetrap.global.' . collect($keyBindings)->map(fn (string $keyBinding): string => str_replace('+', '-', $keyBinding))->implode('.') => $keyBindings ? 'document.getElementById($id(\'input\')).focus()' : null,
                    ])
                )
            "
        />
    </x-wellcms::input.wrapper>
</div>
