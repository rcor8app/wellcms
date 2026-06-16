<?php

namespace WellCMS\Tables\Actions;

use WellCMS\Actions\Concerns\CanReplicateRecords;
use WellCMS\Actions\Contracts\ReplicatesRecords;
use WellCMS\Support\Facades\WellCMSIcon;

class ReplicateAction extends Action implements ReplicatesRecords
{
    use CanReplicateRecords {
        setUp as baseSetUp;
    }

    protected function setUp(): void
    {
        $this->baseSetUp();

        $this->icon(WellCMSIcon::resolve('actions::replicate-action') ?? 'heroicon-m-square-2-stack');
    }
}
