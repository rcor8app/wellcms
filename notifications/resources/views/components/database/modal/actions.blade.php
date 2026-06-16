@props([
    'notifications',
    'unreadNotificationsCount',
])

<div {{ $attributes->class('mt-2 flex gap-x-3') }}>
    @if ($unreadNotificationsCount)
        <x-wellcms::link
            color="primary"
            tabindex="-1"
            tag="button"
            wire:click="markAllNotificationsAsRead"
        >
            {{ __('wellcms-notifications::database.modal.actions.mark_all_as_read.label') }}
        </x-wellcms::link>
    @endif

    <x-wellcms::link
        color="danger"
        tabindex="-1"
        tag="button"
        wire:click="clearNotifications"
        x-on:click="close()"
    >
        {{ __('wellcms-notifications::database.modal.actions.clear.label') }}
    </x-wellcms::link>
</div>
