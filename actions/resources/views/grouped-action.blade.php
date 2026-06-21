<x-wellcms-actions::action
    :action="$action"
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="wellcms::dropdown.list.item"
    :icon="$getGroupedIcon()"
    class="re-ac-grouped-action"
>
    {{ $getLabel() }}
</x-wellcms-actions::action>
