<?php

namespace WellCMS\Tables\Columns\Layout;

use Closure;
use WellCMS\Support\Concerns\HasFromBreakpoint;
use WellCMS\Tables\Columns\Column;

class Split extends Component
{
    use HasFromBreakpoint;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.layout.split';

    /**
     * @param  array<Column | Component> | Closure  $schema
     */
    final public function __construct(array | Closure $schema)
    {
        $this->schema($schema);
    }

    /**
     * @param  array<Column | Component> | Closure  $schema
     */
    public static function make(array | Closure $schema): static
    {
        $static = app(static::class, ['schema' => $schema]);
        $static->configure();

        return $static;
    }
}
