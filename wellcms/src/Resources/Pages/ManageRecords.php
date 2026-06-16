<?php

namespace WellCMS\Resources\Pages;

class ManageRecords extends ListRecords
{
    public function getBreadcrumbs(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs([]);
        }

        return [];
    }
}
