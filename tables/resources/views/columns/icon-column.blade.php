@php
    use WellCMS\Tables\Columns\IconColumn\IconColumnSize;

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
                're-ta-icon flex gap-1.5',
                'flex-wrap' => $canWrap(),
                'px-3 py-4' => ! $isInline(),
                'flex-col' => $isListWithLineBreaks(),
            ])
    }}
>
    @if (count($arrayState))
        @foreach ($arrayState as $state)
            @if ($icon = $getIcon($state))
                @php
                    $color = $getColor($state) ?? 'gray';
                    $size = $getSize($state) ?? IconColumnSize::Large;
                @endphp

                <x-wellcms::icon
                    :icon="$icon"
                    @class([
                        're-ta-icon-item',
                        match ($size) {
                            IconColumnSize::ExtraSmall, 'xs' => 're-ta-icon-item-size-xs h-3 w-3',
                            IconColumnSize::Small, 'sm' => 're-ta-icon-item-size-sm h-4 w-4',
                            IconColumnSize::Medium, 'md' => 're-ta-icon-item-size-md h-5 w-5',
                            IconColumnSize::Large, 'lg' => 're-ta-icon-item-size-lg h-6 w-6',
                            IconColumnSize::ExtraLarge, 'xl' => 're-ta-icon-item-size-xl h-7 w-7',
                            IconColumnSize::TwoExtraLarge, IconColumnSize::ExtraExtraLarge, '2xl' => 're-ta-icon-item-size-2xl h-8 w-8',
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
                            alias: 'tables::columns.icon-column.item',
                        ) => $color !== 'gray',
                    ])
                />
            @endif
        @endforeach
    @elseif (($placeholder = $getPlaceholder()) !== null)
        <x-wellcms-tables::columns.placeholder>
            {{ $placeholder }}
        </x-wellcms-tables::columns.placeholder>
    @endif
</div>
