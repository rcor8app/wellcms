@props([
    'navigation',
])

<x-wellcms::input.wrapper
    wire:ignore
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-page-sub-navigation-select md:hidden'])
    "
>
    <x-wellcms::input.select
        x-data="{}"
        x-on:change="window.location.href = $event.target.value"
    >
        @foreach ($navigation as $navigationGroup)
            @capture($options)
                @foreach ($navigationGroup->getItems() as $navigationItem)
                    @foreach ([$navigationItem, ...$navigationItem->getChildItems()] as $navigationItemChild)
                        <option
                            @selected($navigationItemChild->isActive())
                            value="{{ $navigationItemChild->getUrl() }}"
                        >
                            @if ($loop->index)
                                &ensp;&ensp;
                            @endif

                            {{ $navigationItemChild->getLabel() }}
                        </option>
                    @endforeach
                @endforeach
            @endcapture

            @if (filled($navigationGroupLabel = $navigationGroup->getLabel()))
                <optgroup label="{{ $navigationGroupLabel }}">
                    {{ $options() }}
                </optgroup>
            @else
                {{ $options() }}
            @endif
        @endforeach
    </x-wellcms::input.select>
</x-wellcms::input.wrapper>
