<?php

namespace WellCMS\Forms\Components\Contracts;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

interface HasFileAttachments
{
    public function saveUploadedFileAttachment(TemporaryUploadedFile $attachment): ?string;
}
