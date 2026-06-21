<x-wellcms-actions::action
    :action="$action"
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="wellcms::button"
    :icon-position="$getIconPosition()"
    :labeled-from="$getLabeledFromBreakpoint()"
    :outlined="$isOutlined()"
    :size="$getSize()"
    class="re-ac-btn-action"
>
    {{ $getLabel() }}
</x-wellcms-actions::action>
