<x-wellcms-widgets::widget class="re-wi-table">
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\Widgets\View\WidgetsRenderHook::TABLE_WIDGET_START, scopes: static::class) }}

    {{ $this->table }}

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\Widgets\View\WidgetsRenderHook::TABLE_WIDGET_END, scopes: static::class) }}
</x-wellcms-widgets::widget>
