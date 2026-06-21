<p
    data-validation-error
    {{
        $attributes->class([
            're-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400',
        ])
    }}
>
    {{ $slot }}
</p>
