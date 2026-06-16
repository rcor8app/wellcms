<?php

namespace WellCMS\Actions\Exports\Http\Controllers;

use WellCMS\Actions\Exports\Enums\Contracts\ExportFormat as ExportFormatInterface;
use WellCMS\Actions\Exports\Enums\ExportFormat;
use WellCMS\Actions\Exports\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function WellCMS\authorize;

class DownloadExport
{
    public function __invoke(Request $request, Export $export): StreamedResponse
    {
        if (filled(Gate::getPolicyFor($export::class))) {
            authorize('view', $export);
        } else {
            abort_unless($export->user()->is(auth()->user()), 403);
        }

        $format = $this->resolveFormatFromRequest($request);

        abort_unless($format !== null, 404);

        return $format->getDownloader()($export);
    }

    protected function resolveFormatFromRequest(Request $request): ?ExportFormatInterface
    {
        return ExportFormat::tryFrom($request->query('format'));
    }
}
