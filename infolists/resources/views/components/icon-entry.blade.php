@php
    use WellCMS\Infolists\Components\IconEntry\IconEntrySize;
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $arrayState = $getState();

        if ($arrayState instanceof \Illuminate\Support\Collection) {
            $arrayState = $arrayState->all();
        }

        $arrayState = \Illuminate\Support\Arr::wrap($arrayState);
    @endphp

    <div
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    're-in-icon flex flex-wrap gap-1.5',
                ])
        }}
    >
        @if (count($arrayState))
            @foreach ($arrayState as $state)
                @if ($icon = $getIcon($state))
                    @php
                        $color = $getColor($state) ?? 'gray';
                        $size = $getSize($state) ?? IconEntrySize::Large;
                    @endphp

                    <x-wellcms::icon
                        :icon="$icon"
                        @class([
                            're-in-icon-item',
                            match ($size) {
                                IconEntrySize::ExtraSmall, 'xs' => 're-in-icon-item-size-xs h-3 w-3',
                                IconEntrySize::Small, 'sm' => 're-in-icon-item-size-sm h-4 w-4',
                                IconEntrySize::Medium, 'md' => 're-in-icon-item-size-md h-5 w-5',
                                IconEntrySize::Large, 'lg' => 're-in-icon-item-size-lg h-6 w-6',
                                IconEntrySize::ExtraLarge, 'xl' => 're-in-icon-item-size-xl h-7 w-7',
                                IconEntrySize::TwoExtraLarge, IconEntrySize::ExtraExtraLarge, '2xl' => 're-in-icon-item-size-2xl h-8 w-8',
                                default => $size,
                            },
                            match ($color) {
                                'gray' => 'text-gray-400 dark:text-gray-500',
                                default => 're-color-custom text-custom-500 dark:text-custom-400',
                            },
                            is_string($color) ? 're-color-' . $color : null,
                        ])
                        @style([
                            \WellCMS\Support\get_color_css_variables(
                                $color,
                                shades: [400, 500],
                                alias: 'infolists::components.icon-entry.item',
                            ) => $color !== 'gray',
                        ])
                    />
                @endif
            @endforeach
        @elseif (($placeholder = $getPlaceholder()) !== null)
            <x-wellcms-infolists::entries.placeholder>
                {{ $placeholder }}
            </x-wellcms-infolists::entries.placeholder>
        @endif
    </div>
</x-dynamic-component>
