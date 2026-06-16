<?php

namespace WellCMS\Actions\Exports\Enums\Contracts;

use WellCMS\Actions\Exports\Downloaders\Contracts\Downloader;
use WellCMS\Actions\Exports\Models\Export;
use WellCMS\Notifications\Actions\Action as NotificationAction;

interface ExportFormat
{
    public function getDownloader(): Downloader;

    public function getDownloadNotificationAction(Export $export): NotificationAction;
}
