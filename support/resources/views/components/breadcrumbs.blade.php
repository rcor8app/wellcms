@props([
    'breadcrumbs' => [],
])

@php
    $iconClasses = 're-breadcrumbs-item-separator flex h-5 w-5 text-gray-400 dark:text-gray-500';
    $itemLabelClasses = 're-breadcrumbs-item-label text-sm font-medium text-gray-500 dark:text-gray-400';
@endphp

<nav {{ $attributes->class(['re-breadcrumbs']) }}>
    <ol class="re-breadcrumbs-list flex flex-wrap items-center gap-x-2">
        @foreach ($breadcrumbs as $url => $label)
            <li class="re-breadcrumbs-item flex items-center gap-x-2">
                @if (! $loop->first)
                    <x-wellcms::icon
                        alias="breadcrumbs.separator"
                        icon="heroicon-m-chevron-right"
                        @class([
                            $iconClasses,
                            'rtl:hidden',
                        ])
                    />

                    <x-wellcms::icon
                        {{-- @deprecated Use `breadcrubs.separator.rtl` instead of `breadcrumbs.separator` for RTL. --}}
                        :alias="['breadcrumbs.separator.rtl', 'breadcrumbs.separator']"
                        icon="heroicon-m-chevron-left"
                        @class([
                            $iconClasses,
                            'ltr:hidden',
                        ])
                    />
                @endif

                @if (is_int($url))
                    <span class="{{ $itemLabelClasses }}">
                        {{ $label }}
                    </span>
                @else
                    <a
                        {{ \WellCMS\Support\generate_href_html($url) }}
                        class="{{ $itemLabelClasses }} transition duration-75 hover:text-gray-700 dark:hover:text-gray-200"
                    >
                        {{ $label }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
