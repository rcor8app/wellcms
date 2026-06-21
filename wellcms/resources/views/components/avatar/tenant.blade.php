@props([
    'tenant' => wellcms()->getTenant(),
])

<x-wellcms::avatar
    :circular="false"
    :src="wellcms()->getTenantAvatarUrl($tenant)"
    :alt="__('wellcms-panels::layout.avatar.alt', ['name' => wellcms()->getTenantName($tenant)])"
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->class(['re-tenant-avatar'])
    "
/>
