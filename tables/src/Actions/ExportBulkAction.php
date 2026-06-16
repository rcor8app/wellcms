<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanExportRecords;

class ExportBulkAction extends BulkAction
{
    use CanExportRecords {
        setUp as baseSetUp;
    }

    protected function setUp(): void
    {
        $this->baseSetUp();

        $this->fetchSelectedRecords(false);
    }
}
