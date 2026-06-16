<?php

namespace WellCMS\Actions\Exports\Downloaders\Contracts;

use WellCMS\Actions\Exports\Models\Export;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface Downloader
{
    public function __invoke(Export $export): StreamedResponse;
}
