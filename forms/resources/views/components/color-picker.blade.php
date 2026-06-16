@php
    use WellCMS\Support\Facades\WellCMSView;

    $isDisabled = $isDisabled();
    $isLive = $isLive();
    $isLiveOnBlur = $isLiveOnBlur();
    $isLiveDebounced = $isLiveDebounced();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $liveDebounce = $getLiveDebounce();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
    $placeholder = $getPlaceholder();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :inline-label-vertical-alignment="\WellCMS\Support\Enums\VerticalAlignment::Center"
>
    <x-wellcms::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$getPrefixIconColor()"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$getSuffixIconColor()"
        :valid="! $errors->has($statePath)"
        :attributes="
            \WellCMS\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class('fi-fo-color-picker')
        "
    >
        <div
            @if (WellCMSView::hasSpaMode())
                {{-- format-ignore-start --}}x-load="visible || event (ax-modal-opened)"{{-- format-ignore-end --}}
            @else
                x-load
            @endif
            x-load-src="{{ \WellCMS\Support\Facades\WellCMSAsset::getAlpineComponentSrc('color-picker', 'wellcms/forms') }}"
            x-data="colorPickerFormComponent({
                        isAutofocused: @js($isAutofocused()),
                        isDisabled: @js($isDisabled),
                        isLive: @js($isLive),
                        isLiveDebounced: @js($isLiveDebounced),
                        isLiveOnBlur: @js($isLiveOnBlur),
                        liveDebounce: @js($liveDebounce),
                        state: $wire.$entangle('{{ $statePath }}'),
                    })"
            x-on:keydown.esc="isOpen() && $event.stopPropagation()"
            {{ $getExtraAlpineAttributeBag()->class(['flex']) }}
        >
            <x-wellcms::input
                x-on:focus="$refs.panel.open($refs.input)"
                x-on:keydown.enter.stop.prevent="togglePanelVisibility()"
                x-ref="input"
                :attributes="
                    \WellCMS\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                        ->merge([
                            'autocomplete' => 'off',
                            'disabled' => $isDisabled,
                            'id' => $getId(),
                            'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                            'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                            'placeholder' => filled($placeholder) ? e($placeholder) : null,
                            'required' => $isRequired() && (! $isConcealed()),
                            'type' => 'text',
                            'x-model' . ($isLiveDebounced ? '.debounce.' . $liveDebounce : null) => 'state',
                            'x-on:blur' => $isLiveOnBlur ? 'isOpen() ? null : commitState()' : null,
                        ], escape: false)
                "
            />

            <div
                class="fi-fo-color-picker-preview my-auto me-3 h-5 w-5 shrink-0 select-none rounded-full"
                x-on:click="togglePanelVisibility()"
                x-bind:class="{
                    'ring-1 ring-inset ring-gray-200 dark:ring-white/10': ! state,
                }"
                x-bind:style="{ 'background-color': state }"
            ></div>

            <div
                wire:ignore.self
                wire:key="{{ $this->getId() }}.{{ $statePath }}.{{ $field::class }}.panel"
                x-cloak
                x-float.placement.bottom-start.offset.flip.shift="{ offset: 8 }"
                x-ref="panel"
                class="fi-fo-color-picker-panel absolute z-10 hidden rounded-lg shadow-lg"
            >
                @php
                    $tag = match ($getFormat()) {
                        'hsl' => 'hsl-string',
                        'rgb' => 'rgb-string',
                        'rgba' => 'rgba-string',
                        default => 'hex',
                    } . '-color-picker';
                @endphp

                <{{ $tag }} color="{{ $getState() }}" />
            </div>
        </div>
    </x-wellcms::input.wrapper>
</x-dynamic-component>
