<x-wellcms-actions::group
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="wellcms::dropdown.list.item"
    :group="$group"
    :icon="$getGroupedIcon()"
    class="re-ac-grouped-group"
>
    {{ $getLabel() }}
</x-wellcms-actions::group>
