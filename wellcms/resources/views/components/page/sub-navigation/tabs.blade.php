@props([
    'navigation',
])

<x-wellcms::tabs
    wire:ignore
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-page-sub-navigation-tabs hidden md:flex'])
    "
>
    @foreach ($navigation as $navigationGroup)
        @if ($navigationGroupLabel = $navigationGroup->getLabel())
            <x-wellcms::dropdown placement="bottom-start">
                <x-slot name="trigger">
                    <x-wellcms::tabs.item
                        :active="$navigationGroup->isActive()"
                        :icon="$navigationGroup->getIcon()"
                    >
                        {{ $navigationGroupLabel }}
                    </x-wellcms::tabs.item>
                </x-slot>

                <x-wellcms::dropdown.list>
                    @foreach ($navigationGroup->getItems() as $navigationItem)
                        @php
                            $navigationItemIcon = $navigationItem->getIcon();
                            $navigationItemIcon = $navigationItem->isActive() ? ($navigationItem->getActiveIcon() ?? $navigationItemIcon) : $navigationItemIcon;
                        @endphp

                        <x-wellcms::dropdown.list.item
                            :badge="$navigationItem->getBadge()"
                            :badge-color="$navigationItem->getBadgeColor()"
                            :href="$navigationItem->getUrl()"
                            :icon="$navigationItemIcon"
                            tag="a"
                            :target="$navigationItem->shouldOpenUrlInNewTab() ? '_blank' : null"
                        >
                            {{ $navigationItem->getLabel() }}

                            @if ($navigationItemIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                                <x-slot name="icon">
                                    {{ $navigationItemIcon }}
                                </x-slot>
                            @endif
                        </x-wellcms::dropdown.list.item>
                    @endforeach
                </x-wellcms::dropdown.list>
            </x-wellcms::dropdown>
        @else
            @foreach ($navigationGroup->getItems() as $navigationItem)
                @php
                    $navigationItemIcon = $navigationItem->getIcon();
                    $navigationItemIcon = $navigationItem->isActive() ? ($navigationItem->getActiveIcon() ?? $navigationItemIcon) : $navigationItemIcon;
                @endphp

                <x-wellcms::tabs.item
                    :active="$navigationItem->isActive()"
                    :badge="$navigationItem->getBadge()"
                    :badge-color="$navigationItem->getBadgeColor()"
                    :href="$navigationItem->getUrl()"
                    :icon="$navigationItemIcon"
                    tag="a"
                    :target="$navigationItem->shouldOpenUrlInNewTab() ? '_blank' : null"
                >
                    {{ $navigationItem->getLabel() }}

                    @if ($navigationItemIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                        <x-slot name="icon">
                            {{ $navigationItemIcon }}
                        </x-slot>
                    @endif
                </x-wellcms::tabs.item>
            @endforeach
        @endif
    @endforeach
</x-wellcms::tabs>
