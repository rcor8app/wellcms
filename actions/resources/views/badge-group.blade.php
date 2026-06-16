<x-wellcms-actions::group
    dynamic-component="wellcms::badge"
    :group="$group"
    :icon-position="$getIconPosition()"
    :size="$getSize()"
    class="fi-ac-badge-group"
>
    {{ $getLabel() }}
</x-wellcms-actions::group>
