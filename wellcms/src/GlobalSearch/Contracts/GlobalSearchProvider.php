<?php

namespace WellCMS\GlobalSearch\Contracts;

use WellCMS\GlobalSearch\GlobalSearchResults;

interface GlobalSearchProvider
{
    public function getResults(string $query): ?GlobalSearchResults;
}
