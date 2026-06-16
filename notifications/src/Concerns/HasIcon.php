<?php

namespace WellCMS\Notifications\Concerns;

use WellCMS\Support\Concerns\HasIcon as BaseTrait;
use WellCMS\Support\Facades\WellCMSIcon;

trait HasIcon
{
    use BaseTrait {
        getIcon as baseGetIcon;
    }

    public function getIcon(): ?string
    {
        return $this->baseGetIcon() ?? match ($this->getStatus()) {
            'danger' => WellCMSIcon::resolve('notifications::notification.danger') ?? 'heroicon-o-x-circle',
            'info' => WellCMSIcon::resolve('notifications::notification.info') ?? 'heroicon-o-information-circle',
            'success' => WellCMSIcon::resolve('notifications::notification.success') ?? 'heroicon-o-check-circle',
            'warning' => WellCMSIcon::resolve('notifications::notification.warning') ?? 'heroicon-o-exclamation-circle',
            default => null,
        };
    }
}
