<?php

namespace WellCMS\Models\Contracts;

interface HasAvatar
{
    public function getWellCMSAvatarUrl(): ?string;
}
