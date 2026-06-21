@props([
    'user' => wellcms()->auth()->user(),
])

<x-wellcms::avatar
    :src="wellcms()->getUserAvatarUrl($user)"
    :alt="__('wellcms-panels::layout.avatar.alt', ['name' => wellcms()->getUserName($user)])"
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['re-user-avatar'])
    "
/>
