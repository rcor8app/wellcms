@props([
    'active' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'icon' => null,
    'shouldOpenUrlInNewTab' => false,
    'url' => null,
])

@php
    $tag = $url ? 'a' : 'button';
@endphp

<li
    @class([
        're-topbar-item',
        // @deprecated `fi-topbar-item-active` has been replaced by `fi-active`.
        're-active re-topbar-item-active' => $active,
    ])
>
    <{{ $tag }}
        @if ($url)
            {{ \WellCMS\Support\generate_href_html($url, $shouldOpenUrlInNewTab) }}
        @else
            type="button"
        @endif
        @class([
            're-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5',
            'bg-gray-50 dark:bg-white/5' => $active,
        ])
    >
        @if ($icon || $activeIcon)
            <x-wellcms::icon
                :icon="($active && $activeIcon) ? $activeIcon : $icon"
                @class([
                    're-topbar-item-icon h-5 w-5',
                    'text-gray-400 dark:text-gray-500' => ! $active,
                    'text-primary-600 dark:text-primary-400' => $active,
                ])
            />
        @endif

        <span
            @class([
                're-topbar-item-label text-sm font-medium',
                'text-gray-700 dark:text-gray-200' => ! $active,
                'text-primary-600 dark:text-primary-400' => $active,
            ])
        >
            {{ $slot }}
        </span>

        @if (filled($badge))
            <x-wellcms::badge
                :color="$badgeColor"
                size="sm"
                :tooltip="$badgeTooltip"
            >
                {{ $badge }}
            </x-wellcms::badge>
        @endif

        @if (! $url)
            <x-wellcms::icon
                icon="heroicon-m-chevron-down"
                icon-alias="panels::topbar.group.toggle-button"
                @class([
                    're-topbar-group-toggle-icon h-5 w-5',
                    'text-gray-400 dark:text-gray-500' => ! $active,
                    'text-primary-600 dark:text-primary-400' => $active,
                ])
            />
        @endif
    </{{ $tag }}>
</li>
