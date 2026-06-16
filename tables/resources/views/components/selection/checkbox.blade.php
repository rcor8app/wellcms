@props([
    'label' => null,
])

<label class="flex">
    <x-wellcms::input.checkbox
        :attributes="
            \WellCMS\Support\prepare_inherited_attributes($attributes)
                ->merge([
                    'wire:loading.attr' => 'disabled',
                    'wire:target' => implode(',', \WellCMS\Tables\Table::LOADING_TARGETS),
                ], escape: false)
        "
    />

    @if (filled($label))
        <span class="sr-only">
            {{ $label }}
        </span>
    @endif
</label>
