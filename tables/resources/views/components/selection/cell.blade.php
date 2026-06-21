<x-wellcms-tables::cell
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['re-ta-selection-cell w-1'])
    "
>
    <div class="px-3 py-4">
        {{ $slot }}
    </div>
</x-wellcms-tables::cell>
