@props([
    'columns' => [
        'lg' => 2,
    ],
    'data' => [],
    'widgets' => [],
])

<x-wellcms::grid
    :default="$columns['default'] ?? 1"
    :sm="$columns['sm'] ?? null"
    :md="$columns['md'] ?? null"
    :lg="$columns['lg'] ?? ($columns ? (is_array($columns) ? null : $columns) : 2)"
    :xl="$columns['xl'] ?? null"
    :two-xl="$columns['2xl'] ?? null"
    :attributes="\WellCMS\Support\prepare_inherited_attributes($attributes)->class('re-wi gap-6')"
>
    @php
        $normalizeWidgetClass = function (string | WellCMS\Widgets\WidgetConfiguration $widget): string {
            if ($widget instanceof \WellCMS\Widgets\WidgetConfiguration) {
                return $widget->widget;
            }

            return $widget;
        };
    @endphp

    @foreach ($widgets as $widgetKey => $widget)
        @php
            $widgetClass = $normalizeWidgetClass($widget);
        @endphp

        @livewire(
            $widgetClass,
            [...(($widget instanceof \WellCMS\Widgets\WidgetConfiguration) ? [...$widget->widget::getDefaultProperties(), ...$widget->getProperties()] : $widget::getDefaultProperties()), ...$data],
            key("{$widgetClass}-{$widgetKey}"),
        )
    @endforeach
</x-wellcms::grid>
