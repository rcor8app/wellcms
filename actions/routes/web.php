<?php

use WellCMS\Actions\Exports\Http\Controllers\DownloadExport;
use WellCMS\Actions\Imports\Http\Controllers\DownloadImportFailureCsv;
use Illuminate\Support\Facades\Route;

$prefix = config('wellcms.system_route_prefix', 'wellcms');

Route::middleware('wellcms.actions')
    ->name('wellcms.')
    ->prefix($prefix)
    ->group(function () {
        Route::get('/exports/{export}/download', DownloadExport::class)
            ->name('exports.download');

        Route::get('/imports/{import}/failed-rows/download', DownloadImportFailureCsv::class)
            ->name('imports.failed-rows.download');
    });
