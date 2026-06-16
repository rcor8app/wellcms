<?php

namespace WellCMS\Forms\Components\Concerns;

use Closure;

trait HasUploadingMessage
{
    protected string | Closure | null $uploadingMessage = null;

    public function uploadingMessage(string | Closure | null $message): static
    {
        $this->uploadingMessage = $message;

        return $this;
    }

    public function getUploadingMessage(): string
    {
        return $this->evaluate($this->uploadingMessage) ?? __('wellcms::components/button.messages.uploading_file');
    }
}
