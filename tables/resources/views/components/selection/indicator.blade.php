@php
    $locale = app()->getLocale();
@endphp

@props([
    'allSelectableRecordsCount',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'page' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectCurrentPageOnly' => false,
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
])

<div
    x-cloak
    {{
        $attributes
            ->merge([
                'wire:key' => "{$this->getId()}.table.selection.indicator",
            ], escape: false)
            ->class([
                're-ta-selection-indicator flex flex-col justify-between gap-y-1 bg-gray-50 px-3 py-2 dark:bg-white/5 sm:flex-row sm:items-center sm:px-6 sm:py-1.5',
            ])
    }}
>
    <div class="flex gap-x-3">
        <x-wellcms::loading-indicator
            x-show="isLoading"
            class="h-5 w-5 text-gray-400 dark:text-gray-500"
        />

        <span
            x-text="
                window.pluralize(@js(__('wellcms-tables::table.selection_indicator.selected_count')), {{ $selectedRecordsPropertyName }}.length, {
                    count: new Intl.NumberFormat(@js(str_replace('_', '-', $locale))).format(
                        {{ $selectedRecordsPropertyName }}.length,
                    ),
                })
            "
            class="text-sm font-medium leading-6 text-gray-700 dark:text-gray-200"
        ></span>
    </div>

    <div class="flex gap-x-3">
        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\Tables\View\TablesRenderHook::SELECTION_INDICATOR_ACTIONS_BEFORE, scopes: static::class) }}

        <div class="flex gap-x-3">
            <x-wellcms::link
                color="primary"
                tag="button"
                :x-on:click="$selectAllRecordsAction"
                :x-show="$selectCurrentPageOnly ? '! areRecordsSelected(getRecordsOnPage())' : $allSelectableRecordsCount . ' !== ' . $selectedRecordsPropertyName . '.length'"
                {{-- Make sure the Alpine attributes get re-evaluated after a Livewire request: --}}
                :wire:key="$this->getId() . 'table.selection.indicator.actions.select-all.' . $allSelectableRecordsCount . '.' . $page"
            >
                {{ trans_choice('wellcms-tables::table.selection_indicator.actions.select_all.label', $allSelectableRecordsCount, ['count' => \Illuminate\Support\Number::format($allSelectableRecordsCount, locale: $locale)]) }}
            </x-wellcms::link>

            <x-wellcms::link
                color="danger"
                tag="button"
                :x-on:click="$deselectAllRecordsAction"
            >
                {{ __('wellcms-tables::table.selection_indicator.actions.deselect_all.label') }}
            </x-wellcms::link>
        </div>

        {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\Tables\View\TablesRenderHook::SELECTION_INDICATOR_ACTIONS_AFTER, scopes: static::class) }}

        {{ $end }}
    </div>
</div>
