<?php

namespace WellCMS\Resources\Components;

use Closure;
use WellCMS\Support\Components\Component;
use WellCMS\Support\Concerns\HasBadge;
use WellCMS\Support\Concerns\HasExtraAttributes;
use WellCMS\Support\Concerns\HasIcon;
use Illuminate\Database\Eloquent\Builder;

class Tab extends Component
{
    use HasBadge;
    use HasExtraAttributes;
    use HasIcon;

    protected string | Closure | null $label = null;

    protected ?Closure $modifyQueryUsing = null;

    public function __construct(string | Closure | null $label = null)
    {
        $this->label($label);
    }

    public static function make(string | Closure | null $label = null): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->configure();

        return $static;
    }

    public function label(string | Closure | null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function query(?Closure $callback): static
    {
        $this->modifyQueryUsing($callback);

        return $this;
    }

    public function modifyQueryUsing(?Closure $callback): static
    {
        $this->modifyQueryUsing = $callback;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    public function modifyQuery(Builder $query): Builder
    {
        return $this->evaluate($this->modifyQueryUsing, [
            'query' => $query,
        ]) ?? $query;
    }
}
