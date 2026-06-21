@php
    $user = wellcms()->auth()->user();
@endphp

<x-wellcms-widgets::widget class="re-account-widget">
    <x-wellcms::section>
        <div class="flex items-center gap-x-3">
            <x-wellcms-panels::avatar.user size="lg" :user="$user" />

            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    {{ __('wellcms-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ wellcms()->getUserName($user) }}
                </p>
            </div>

            <form
                action="{{ wellcms()->getLogoutUrl() }}"
                method="post"
                class="my-auto"
            >
                @csrf

                <x-wellcms::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('wellcms-panels::widgets/account-widget.actions.logout.label') }}
                </x-wellcms::button>
            </form>
        </div>
    </x-wellcms::section>
</x-wellcms-widgets::widget>
