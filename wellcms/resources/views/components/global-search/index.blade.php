<div
    x-data="{}"
    x-on:focus-first-global-search-result.stop="$el.querySelector('.fi-global-search-result-link')?.focus()"
    class="re-global-search flex items-center"
>
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::GLOBAL_SEARCH_START) }}

    <div class="sm:relative">
        <x-wellcms-panels::global-search.field />

        @if ($results !== null)
            <x-wellcms-panels::global-search.results-container
                :results="$results"
            />
        @endif
    </div>

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::GLOBAL_SEARCH_END) }}
</div>
