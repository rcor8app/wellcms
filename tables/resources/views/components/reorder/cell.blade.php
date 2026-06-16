<x-wellcms-tables::cell
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['w-1'])
    "
>
    <div class="px-3">
        {{ $slot }}
    </div>
</x-wellcms-tables::cell>
