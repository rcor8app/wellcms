<x-wellcms::fieldset
    :label="$getLabel()"
    :label-hidden="$isLabelHidden()"
    :required="isset($isMarkedAsRequired) ? $isMarkedAsRequired() : false"
    :attributes="
        \WellCMS\Support\prepare_inherited_attributes($attributes)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
    "
>
    {{ $getChildComponentContainer() }}
</x-wellcms::fieldset>
