@props([
    'directionSetting' => false,
    'dropdownOnDesktop' => false,
    'groups',
    'triggerAction',
])

@php
    $labelClasses = 'text-sm font-medium leading-6 text-gray-950 dark:text-white';
@endphp

<div
    x-data="{
        direction: $wire.$entangle('tableGroupingDirection', true),
        group: $wire.$entangle('tableGrouping', true),
    }"
    x-init="
        $watch('group', function (newGroup, oldGroup) {
            if (newGroup && direction) {
                return
            }

            if (! newGroup) {
                direction = null

                return
            }

            if (oldGroup) {
                return
            }

            direction = 'asc'
        })
    "
>
    <x-wellcms::dropdown
        placement="bottom-start"
        shift
        width="xs"
        wire:key="{{ $this->getId() }}.table.grouping"
        :attributes="
            \WellCMS\Support\prepare_inherited_attributes($attributes)
                ->class([
                    'sm:hidden' => ! $dropdownOnDesktop,
                ])
        "
    >
        <x-slot name="trigger">
            {{ $triggerAction }}
        </x-slot>

        <div class="grid gap-y-6 p-6">
            <label class="grid gap-y-2">
                <span class="{{ $labelClasses }}">
                    {{ __('wellcms-tables::table.grouping.fields.group.label') }}
                </span>

                <x-wellcms::input.wrapper>
                    <x-wellcms::input.select
                        x-model="group"
                        x-on:change="resetCollapsedGroups()"
                    >
                        <option value="">-</option>

                        @foreach ($groups as $group)
                            <option value="{{ $group->getId() }}">
                                {{ $group->getLabel() }}
                            </option>
                        @endforeach
                    </x-wellcms::input.select>
                </x-wellcms::input.wrapper>
            </label>

            @if (! $directionSetting)
                <label x-cloak x-show="group" class="grid gap-y-2">
                    <span class="{{ $labelClasses }}">
                        {{ __('wellcms-tables::table.grouping.fields.direction.label') }}
                    </span>

                    <x-wellcms::input.wrapper>
                        <x-wellcms::input.select x-model="direction">
                            <option value="asc">
                                {{ __('wellcms-tables::table.grouping.fields.direction.options.asc') }}
                            </option>

                            <option value="desc">
                                {{ __('wellcms-tables::table.grouping.fields.direction.options.desc') }}
                            </option>
                        </x-wellcms::input.select>
                    </x-wellcms::input.wrapper>
                </label>
            @endif
        </div>
    </x-wellcms::dropdown>

    @if (! $dropdownOnDesktop)
        <div class="hidden items-center gap-x-3 sm:flex">
            <label>
                <span class="sr-only">
                    {{ __('wellcms-tables::table.grouping.fields.group.label') }}
                </span>

                <x-wellcms::input.wrapper>
                    <x-wellcms::input.select
                        x-model="group"
                        x-on:change="resetCollapsedGroups()"
                    >
                        <option value="">
                            {{ __('wellcms-tables::table.grouping.fields.group.placeholder') }}
                        </option>

                        @foreach ($groups as $group)
                            <option value="{{ $group->getId() }}">
                                {{ $group->getLabel() }}
                            </option>
                        @endforeach
                    </x-wellcms::input.select>
                </x-wellcms::input.wrapper>
            </label>

            @if (! $directionSetting)
                <label x-cloak x-show="group">
                    <span class="sr-only">
                        {{ __('wellcms-tables::table.grouping.fields.direction.label') }}
                    </span>

                    <x-wellcms::input.wrapper>
                        <x-wellcms::input.select x-model="direction">
                            <option value="asc">
                                {{ __('wellcms-tables::table.grouping.fields.direction.options.asc') }}
                            </option>

                            <option value="desc">
                                {{ __('wellcms-tables::table.grouping.fields.direction.options.desc') }}
                            </option>
                        </x-wellcms::input.select>
                    </x-wellcms::input.wrapper>
                </label>
            @endif
        </div>
    @endif
</div>
