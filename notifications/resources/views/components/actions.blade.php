@props([
    'actions',
])

<div
    {{ $attributes->class(['re-no-notification-actions flex gap-x-3']) }}
>
    @foreach ($actions as $action)
        {{ $action }}
    @endforeach
</div>
