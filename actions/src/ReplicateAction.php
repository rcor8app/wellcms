<?php

namespace WellCMS\Actions;

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

        $this->groupedIcon(WellCMSIcon::resolve('actions::replicate-action.grouped') ?? 'heroicon-m-square-2-stack');
    }
}
