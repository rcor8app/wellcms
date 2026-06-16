@if (wellcms()->hasUnsavedChangesAlerts())
    @script
        <script>
            window.addEventListener('beforeunload', (event) => {
                if (typeof @this === 'undefined') {
                    return
                }

                if (
                    [
                        ...(@js($this instanceof \WellCMS\Actions\Contracts\HasActions) ? ($wire.mountedActions ?? []) : []),
                        ...(@js($this instanceof \WellCMS\Forms\Contracts\HasForms)
                            ? ($wire.mountedFormComponentActions ?? [])
                            : []),
                        ...(@js($this instanceof \WellCMS\Infolists\Contracts\HasInfolists)
                            ? ($wire.mountedInfolistActions ?? [])
                            : []),
                        ...(@js($this instanceof \WellCMS\Tables\Contracts\HasTable)
                            ? [
                                  ...($wire.mountedTableActions ?? []),
                                  ...($wire.mountedTableBulkAction
                                      ? [$wire.mountedTableBulkAction]
                                      : []),
                              ]
                            : []),
                    ].length &&
                    !$wire?.__instance?.effects?.redirect
                ) {
                    event.preventDefault()
                    event.returnValue = true

                    return
                }
            })
        </script>
    @endscript
@endif
