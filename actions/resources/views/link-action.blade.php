<x-wellcms-actions::action
    :action="$action"
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="wellcms::link"
    :icon-position="$getIconPosition()"
    :size="$getSize()"
    class="fi-ac-link-action"
>
    {{ $getLabel() }}
</x-wellcms-actions::action>
