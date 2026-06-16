<?php

namespace WellCMS\Actions\Contracts;

interface ReplicatesRecords
{
    public function callBeforeReplicaSaved(): void;

    /**
     * @return array<string> | null
     */
    public function getExcludedAttributes(): ?array;
}
