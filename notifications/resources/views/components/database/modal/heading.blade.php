@props([
    'unreadNotificationsCount',
])

<x-wellcms::modal.heading>
    <span class="relative">
        {{ __('wellcms-notifications::database.modal.heading') }}

        @if ($unreadNotificationsCount)
            <x-wellcms::badge
                size="xs"
                class="absolute -top-1 start-full ms-1 w-max"
            >
                {{ $unreadNotificationsCount }}
            </x-wellcms::badge>
        @endif
    </span>
</x-wellcms::modal.heading>
