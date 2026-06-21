@php
    use WellCMS\Support\Enums\Alignment;
    use WellCMS\Support\Enums\VerticalAlignment;
@endphp

<div>
    <div
        @class([
            're-no pointer-events-none fixed inset-4 z-50 mx-auto flex gap-3',
            match (static::$alignment) {
                Alignment::Start, Alignment::Left => 'items-start',
                Alignment::Center => 'items-center',
                Alignment::End, Alignment::Right => 'items-end',
                default => null,
            },
            match (static::$verticalAlignment) {
                VerticalAlignment::Start => 'flex-col-reverse justify-end',
                VerticalAlignment::End => 'flex-col justify-end',
                VerticalAlignment::Center => 'flex-col justify-center',
            },
        ])
        role="status"
    >
        @foreach ($notifications as $notification)
            {{ $notification }}
        @endforeach
    </div>

    @if ($broadcastChannel = $this->getBroadcastChannel())
        <x-wellcms-notifications::echo :channel="$broadcastChannel" />
    @endif
</div>
