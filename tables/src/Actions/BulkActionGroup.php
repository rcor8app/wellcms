<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Support\Facades\WellCMSIcon;

class BulkActionGroup extends ActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('wellcms-tables::table.actions.open_bulk_actions.label'));

        $this->icon(WellCMSIcon::resolve('tables::actions.open-bulk-actions') ?? 'heroicon-m-ellipsis-vertical');

        $this->defaultColor('gray');

        $this->button();

        $this->dropdownPlacement('bottom-start');

        $this->labeledFrom('sm');
    }
}
