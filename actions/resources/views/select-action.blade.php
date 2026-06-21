@php
    $id = $getId();
    $isDisabled = $isDisabled();
@endphp

<div class="re-ac-select-action">
    <label for="{{ $id }}" class="sr-only">
        {{ $getLabel() }}
    </label>

    <x-wellcms::input.wrapper :disabled="$isDisabled">
        <x-wellcms::input.select
            :disabled="$isDisabled"
            :id="$id"
            :wire:model.live="$getName()"
        >
            @if (($placeholder = $getPlaceholder()) !== null)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach ($getOptions() as $value => $label)
                <option value="{{ $value }}">
                    {{ $label }}
                </option>
            @endforeach
        </x-wellcms::input.select>
    </x-wellcms::input.wrapper>
</div>
