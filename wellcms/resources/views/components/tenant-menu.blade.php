@php
    $currentTenant = wellcms()->getTenant();
    $currentTenantName = wellcms()->getTenantName($currentTenant);
    $items = wellcms()->getTenantMenuItems();

    $billingItem = $items['billing'] ?? null;
    $billingItemUrl = $billingItem?->getUrl();
    $isBillingItemVisible = $billingItem?->isVisible() ?? true;
    $hasBillingItem = (wellcms()->hasTenantBilling() || filled($billingItemUrl)) && $isBillingItemVisible;

    $registrationItem = $items['register'] ?? null;
    $registrationItemUrl = $registrationItem?->getUrl();
    $isRegistrationItemVisible = $registrationItem?->isVisible() ?? true;
    $hasRegistrationItem = ((wellcms()->hasTenantRegistration() && wellcms()->getTenantRegistrationPage()::canView()) || filled($registrationItemUrl)) && $isRegistrationItemVisible;

    $profileItem = $items['profile'] ?? null;
    $profileItemUrl = $profileItem?->getUrl();
    $isProfileItemVisible = $profileItem?->isVisible() ?? true;
    $hasProfileItem = ((wellcms()->hasTenantProfile() && wellcms()->getTenantProfilePage()::canView($currentTenant)) || filled($profileItemUrl)) && $isProfileItemVisible;

    $canSwitchTenants = count($tenants = array_filter(
        wellcms()->getUserTenants(wellcms()->auth()->user()),
        fn (\Illuminate\Database\Eloquent\Model $tenant): bool => ! $tenant->is($currentTenant),
    ));

    $items = \Illuminate\Support\Arr::except($items, ['billing', 'profile', 'register']);
@endphp

{{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TENANT_MENU_BEFORE) }}

<x-wellcms::dropdown
    placement="bottom-start"
    size
    teleport
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-tenant-menu'])
    "
>
    <x-slot name="trigger">
        <button
            @if (wellcms()->isSidebarCollapsibleOnDesktop())
                x-data="{ tooltip: false }"
                x-effect="
                    tooltip = $store.sidebar.isOpen
                        ? false
                        : {
                              content: @js($currentTenantName),
                              placement: document.dir === 'rtl' ? 'left' : 'right',
                              theme: $store.theme,
                          }
                "
                x-tooltip.html="tooltip"
            @endif
            type="button"
            class="fi-tenant-menu-trigger group flex w-full items-center justify-center gap-x-3 rounded-lg p-2 text-sm font-medium outline-none transition duration-75 hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5"
        >
            <x-wellcms-panels::avatar.tenant
                :tenant="$currentTenant"
                class="shrink-0"
            />

            <span
                @if (wellcms()->isSidebarCollapsibleOnDesktop())
                    x-show="$store.sidebar.isOpen"
                @endif
                class="grid justify-items-start text-start"
            >
                @if ($currentTenant instanceof \WellCMS\Models\Contracts\HasCurrentTenantLabel)
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $currentTenant->getCurrentTenantLabel() }}
                    </span>
                @endif

                <span class="text-gray-950 dark:text-white">
                    {{ $currentTenantName }}
                </span>
            </span>

            <x-wellcms::icon
                icon="heroicon-m-chevron-down"
                alias="panels::tenant-menu.toggle-button"
                :x-show="wellcms()->isSidebarCollapsibleOnDesktop() ? '$store.sidebar.isOpen' : null"
                class="ms-auto h-5 w-5 shrink-0 text-gray-400 transition duration-75 group-hover:text-gray-500 group-focus-visible:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus-visible:text-gray-400"
            />
        </button>
    </x-slot>

    @if ($hasProfileItem || $hasBillingItem)
        <x-wellcms::dropdown.list>
            @if ($hasProfileItem)
                <x-wellcms::dropdown.list.item
                    :color="$profileItem?->getColor()"
                    :href="$profileItemUrl ?? wellcms()->getTenantProfileUrl()"
                    :icon="$profileItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::tenant-menu.profile-button') ?? 'heroicon-m-cog-6-tooth'"
                    tag="a"
                    :target="($profileItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
                >
                    {{ $profileItem?->getLabel() ?? wellcms()->getTenantProfilePage()::getLabel() }}
                </x-wellcms::dropdown.list.item>
            @endif

            @if ($hasBillingItem)
                <x-wellcms::dropdown.list.item
                    :color="$billingItem?->getColor() ?? 'gray'"
                    :href="$billingItemUrl ?? wellcms()->getTenantBillingUrl()"
                    :icon="$billingItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::tenant-menu.billing-button') ?? 'heroicon-m-credit-card'"
                    tag="a"
                    :target="($billingItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
                >
                    {{ $billingItem?->getLabel() ?? __('wellcms-panels::layout.actions.billing.label') }}
                </x-wellcms::dropdown.list.item>
            @endif
        </x-wellcms::dropdown.list>
    @endif

    @if (count($items))
        <x-wellcms::dropdown.list>
            @foreach ($items as $item)
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
        </x-wellcms::dropdown.list>
    @endif

    @if ($canSwitchTenants)
        <x-wellcms::dropdown.list>
            @foreach ($tenants as $tenant)
                <x-wellcms::dropdown.list.item
                    :href="wellcms()->getUrl($tenant)"
                    :image="wellcms()->getTenantAvatarUrl($tenant)"
                    tag="a"
                >
                    {{ wellcms()->getTenantName($tenant) }}
                </x-wellcms::dropdown.list.item>
            @endforeach
        </x-wellcms::dropdown.list>
    @endif

    @if ($hasRegistrationItem)
        <x-wellcms::dropdown.list>
            <x-wellcms::dropdown.list.item
                :color="$registrationItem?->getColor()"
                :href="$registrationItemUrl ?? wellcms()->getTenantRegistrationUrl()"
                :icon="$registrationItem?->getIcon() ?? \WellCMS\Support\Facades\WellCMSIcon::resolve('panels::tenant-menu.registration-button') ?? 'heroicon-m-plus'"
                tag="a"
                :target="($registrationItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
            >
                {{ $registrationItem?->getLabel() ?? wellcms()->getTenantRegistrationPage()::getLabel() }}
            </x-wellcms::dropdown.list.item>
        </x-wellcms::dropdown.list>
    @endif
</x-wellcms::dropdown>

{{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::TENANT_MENU_AFTER) }}
