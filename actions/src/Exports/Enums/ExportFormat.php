<?php

namespace WellCMS\Actions\Exports\Enums;

use WellCMS\Actions\Exports\Downloaders\Contracts\Downloader;
use WellCMS\Actions\Exports\Downloaders\CsvDownloader;
use WellCMS\Actions\Exports\Downloaders\XlsxDownloader;
use WellCMS\Actions\Exports\Enums\Contracts\ExportFormat as ExportFormatInterface;
use WellCMS\Actions\Exports\Models\Export;
use WellCMS\Notifications\Actions\Action as NotificationAction;

enum ExportFormat: string implements ExportFormatInterface
{
    case Csv = 'csv';

    case Xlsx = 'xlsx';

    public function getDownloader(): Downloader
    {
        return match ($this) {
            self::Csv => app(CsvDownloader::class),
            self::Xlsx => app(XlsxDownloader::class),
        };
    }

    public function getDownloadNotificationAction(Export $export): NotificationAction
    {
        return NotificationAction::make("download_{$this->value}")
            ->label(__("wellcms-actions::export.notifications.completed.actions.download_{$this->value}.label"))
            ->url(route('wellcms.exports.download', ['export' => $export, 'format' => $this], absolute: false), shouldOpenInNewTab: true)
            ->markAsRead();
    }
}
