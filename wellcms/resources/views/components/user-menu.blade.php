@php
    $user = wellcms()->auth()->user();
    $items = wellcms()->getUserMenuItems();

    $profileItem = $items['profile'] ?? $items['account'] ?? null;
    $profileItemUrl = $profileItem?->getUrl();
    $profilePage = wellcms()->getProfilePage();
    $hasProfileItem = wellcms()->hasProfile() || filled($profileItemUrl);

    $logoutItem = $items['logout'] ?? null;

    $items = \Illuminate\Support\Arr::except($items, ['account', 'logout', 'profile']);
@endphp

{{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::USER_MENU_BEFORE) }}

<x-wellcms::dropdown
    placement="bottom-end"
    teleport
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['re-user-menu'])
    "
>
    <x-slot name="trigger">
        <button
            aria-label="{{ __('wellcms-panels::layout.actions.open_user_menu.label') }}"
            type="button"
            class="shrink-0"
        >
            <x-wellcms-panels::avatar.user :user="$user" />
        </button>
    </x-slot>

    @if ($profileItem?->isVisible() ?? true)
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::USER_MENU_PROFILE_BEFORE) }}

        @if ($hasProfileItem)
            <x-wellcms::dropdown.list>
                <x-wellcms::dropdown.list.item
                    :color="$profileItem?->getColor()"
                    :icon="$profileItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::user-menu.profile-item') ?? 'heroicon-m-user-circle'"
                    :href="$profileItemUrl ?? wellcms()->getProfileUrl()"
                    :target="($profileItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
                    tag="a"
                >
                    {{ $profileItem?->getLabel() ?? ($profilePage ? $profilePage::getLabel() : null) ?? wellcms()->getUserName($user) }}
                </x-wellcms::dropdown.list.item>
            </x-wellcms::dropdown.list>
        @else
            <x-wellcms::dropdown.header
                :color="$profileItem?->getColor()"
                :icon="$profileItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::user-menu.profile-item') ?? 'heroicon-m-user-circle'"
            >
                {{ $profileItem?->getLabel() ?? wellcms()->getUserName($user) }}
            </x-wellcms::dropdown.header>
        @endif

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::USER_MENU_PROFILE_AFTER) }}
    @endif

    @if (wellcms()->hasDarkMode() && (! wellcms()->hasDarkModeForced()))
        <x-wellcms::dropdown.list>
            <x-wellcms-panels::theme-switcher />
        </x-wellcms::dropdown.list>
    @endif

    <x-wellcms::dropdown.list>
        @foreach ($items as $key => $item)
            @php
                $itemPostAction = $item->getPostAction();
            @endphp

            <x-wellcms::dropdown.list.item
                :action="$itemPostAction"
                :color="$item->getColor()"
                :href="$item->getUrl()"
                :icon="$item->getIcon()"
                :method="filled($itemPostAction) ? 'post' : null"
                :tag="filled($itemPostAction) ? 'form' : 'a'"
                :target="$item->shouldOpenUrlInNewTab() ? '_blank' : null"
            >
                {{ $item->getLabel() }}
            </x-wellcms::dropdown.list.item>
        @endforeach

        <x-wellcms::dropdown.list.item
            :action="$logoutItem?->getUrl() ?? wellcms()->getLogoutUrl()"
            :color="$logoutItem?->getColor()"
            :icon="$logoutItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::user-menu.logout-button') ?? 'heroicon-m-arrow-left-on-rectangle'"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('wellcms-panels::layout.actions.logout.label') }}
        </x-wellcms::dropdown.list.item>
    </x-wellcms::dropdown.list>
</x-wellcms::dropdown>

{{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::USER_MENU_AFTER) }}
