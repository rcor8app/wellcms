<?php

namespace WellCMS\Tables\Columns;

use Closure;
use WellCMS\Forms\Components\Concerns\HasExtraInputAttributes;
use WellCMS\Forms\Components\Concerns\HasInputMode;
use WellCMS\Forms\Components\Concerns\HasStep;
use WellCMS\Support\RawJs;
use WellCMS\Tables\Columns\Contracts\Editable;

class TextInputColumn extends Column implements Editable
{
    use Concerns\CanBeValidated;
    use Concerns\CanUpdateState;
    use HasExtraInputAttributes;
    use HasInputMode;
    use HasStep;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.text-input-column';

    protected string | RawJs | Closure | null $mask = null;

    protected string | Closure | null $type = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabledClick();
    }

    public function type(string | Closure | null $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->evaluate($this->type) ?? 'text';
    }

    public function mask(string | RawJs | Closure | null $mask): static
    {
        $this->mask = $mask;

        return $this;
    }

    public function getMask(): string | RawJs | null
    {
        return $this->evaluate($this->mask);
    }
}
