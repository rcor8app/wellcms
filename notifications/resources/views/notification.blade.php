@php
    use WellCMS\Notifications\Livewire\Notifications;
    use WellCMS\Support\Enums\Alignment;
    use WellCMS\Support\Enums\VerticalAlignment;
    use Illuminate\Support\Arr;

    $color = $getColor() ?? 'gray';
    $isInline = $isInline();
    $status = $getStatus();
    $title = $getTitle();
    $hasTitle = filled($title);
    $date = $getDate();
    $hasDate = filled($date);
    $body = $getBody();
    $hasBody = filled($body);
@endphp

<x-wellcms-notifications::notification
    :notification="$notification"
    :x-transition:enter-start="
        Arr::toCssClasses([
            'opacity-0',
            ($this instanceof Notifications)
            ? match (static::$alignment) {
                Alignment::Start, Alignment::Left => '-translate-x-12',
                Alignment::End, Alignment::Right => 'translate-x-12',
                Alignment::Center => match (static::$verticalAlignment) {
                    VerticalAlignment::Start => '-translate-y-12',
                    VerticalAlignment::End => 'translate-y-12',
                    default => null,
                },
                default => null,
            }
            : null,
        ])
    "
    :x-transition:leave-end="
        Arr::toCssClasses([
            'opacity-0',
            'scale-95' => ! $isInline,
        ])
    "
    @class([
        're-no-notification w-full overflow-hidden transition duration-300',
        ...match ($isInline) {
            true => [
                're-inline',
            ],
            false => [
                'max-w-sm rounded-xl bg-white shadow-lg ring-1 dark:bg-gray-900',
                match ($color) {
                    'gray' => 'ring-gray-950/5 dark:ring-white/10',
                    default => 're-color-custom ring-custom-600/20 dark:ring-custom-400/30',
                },
                is_string($color) ? 're-color-' . $color : null,
                're-status-' . $status => $status,
            ],
        },
    ])
    @style([
        \WellCMS\Support\get_color_css_variables(
            $color,
            shades: [50, 400, 600],
            alias: 'notifications::notification',
        ) => ! ($isInline || $color === 'gray'),
    ])
>
    <div
        @class([
            'flex w-full gap-3 p-4',
            match ($color) {
                'gray' => null,
                default => 'bg-custom-50 dark:bg-custom-400/10',
            },
        ])
    >
        @if ($icon = $getIcon())
            <x-wellcms-notifications::icon
                :color="$getIconColor()"
                :icon="$icon"
                :size="$getIconSize()"
            />
        @endif

        <div class="mt-0.5 grid flex-1">
            @if ($hasTitle)
                <x-wellcms-notifications::title>
                    {{ str($title)->sanitizeHtml()->toHtmlString() }}
                </x-wellcms-notifications::title>
            @endif

            @if ($hasDate)
                <x-wellcms-notifications::date @class(['mt-1' => $hasTitle])>
                    {{ $date }}
                </x-wellcms-notifications::date>
            @endif

            @if ($hasBody)
                <x-wellcms-notifications::body
                    @class(['mt-1' => $hasTitle || $hasDate])
                >
                    {{ str($body)->sanitizeHtml()->toHtmlString() }}
                </x-wellcms-notifications::body>
            @endif

            @if ($actions = $getActions())
                <x-wellcms-notifications::actions
                    :actions="$actions"
                    @class(['mt-3' => $hasTitle || $hasDate || $hasBody])
                />
            @endif
        </div>

        <x-wellcms-notifications::close-button />
    </div>
</x-wellcms-notifications::notification>
