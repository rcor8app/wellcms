<x-wellcms-actions::group
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="wellcms::link"
    :group="$group"
    :icon-position="$getIconPosition()"
    :size="$getSize()"
    tag="button"
    class="fi-ac-link-group"
>
    {{ $getLabel() }}
</x-wellcms-actions::group>
