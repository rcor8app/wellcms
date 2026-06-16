<?php

namespace WellCMS\Actions\Concerns;

use Closure;
use WellCMS\Support\Facades\WellCMSView;

trait CanRedirect
{
    protected string | Closure | null $failureRedirectUrl = null;

    protected string | Closure | null $successRedirectUrl = null;

    public function dispatchFailureRedirect(): static
    {
        $url = $this->evaluate($this->failureRedirectUrl);

        if (filled($url)) {
            $this->redirect($url);
        }

        return $this;
    }

    public function dispatchSuccessRedirect(): static
    {
        $url = $this->evaluate($this->successRedirectUrl);

        if (filled($url)) {
            $this->redirect($url);
        }

        return $this;
    }

    public function redirect(string | Closure $url, ?bool $navigate = null): void
    {
        $url = $this->evaluate($url);

        $this->getLivewire()->redirect($url, navigate: $navigate ?? WellCMSView::hasSpaMode($url));
    }

    public function failureRedirectUrl(string | Closure | null $url): static
    {
        $this->failureRedirectUrl = $url;

        return $this;
    }

    public function successRedirectUrl(string | Closure | null $url): static
    {
        $this->successRedirectUrl = $url;

        return $this;
    }
}
