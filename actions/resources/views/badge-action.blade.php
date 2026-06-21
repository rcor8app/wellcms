<x-wellcms-actions::action
    :action="$action"
    dynamic-component="wellcms::badge"
    :icon-position="$getIconPosition()"
    :size="$getSize()"
    class="re-ac-badge-action"
>
    {{ $getLabel() }}
</x-wellcms-actions::action>
