@php
    $notifications = $this->getNotifications();
    $unreadNotificationsCount = $this->getUnreadNotificationsCount();
@endphp

<div
    @if ($pollingInterval = $this->getPollingInterval())
        wire:poll.{{ $pollingInterval }}
    @endif
    class="flex"
>
    @if ($trigger = $this->getTrigger())
        <x-wellcms-notifications::database.trigger>
            {{ $trigger->with(['unreadNotificationsCount' => $unreadNotificationsCount]) }}
        </x-wellcms-notifications::database.trigger>
    @endif

    <x-wellcms-notifications::database.modal
        :notifications="$notifications"
        :unread-notifications-count="$unreadNotificationsCount"
    />

    @if ($broadcastChannel = $this->getBroadcastChannel())
        <x-wellcms-notifications::database.echo
            :channel="$broadcastChannel"
        />
    @endif
</div>
