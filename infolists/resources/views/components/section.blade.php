@php
    $isAside = $isAside();
@endphp

<x-wellcms::section
    :aside="$isAside"
    :collapsed="$isCollapsed()"
    :collapsible="$isCollapsible() && (! $isAside)"
    :compact="$isCompact()"
    :content-before="$isContentBefore()"
    :description="$getDescription()"
    :footer-actions="$getFooterActions()"
    :footer-actions-alignment="$getFooterActionsAlignment()"
    :header-actions="$getHeaderActions()"
    :heading="$getHeading()"
    :icon="$getIcon()"
    :icon-color="$getIconColor()"
    :icon-size="$getIconSize()"
    :persist-collapsed="$shouldPersistCollapsed()"
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->merge($getExtraAlpineAttributes(), escape: false)
    "
>
    {{ $getChildComponentContainer() }}
</x-wellcms::section>
