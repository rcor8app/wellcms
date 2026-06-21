<x-wellcms-tables::cell
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['re-ta-actions-cell'])
    "
>
    <div class="whitespace-nowrap px-3 py-4">
        {{ $slot }}
    </div>
</x-wellcms-tables::cell>
