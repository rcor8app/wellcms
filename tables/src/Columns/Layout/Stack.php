<?php

namespace WellCMS\Tables\Columns\Layout;

use Closure;
use WellCMS\Support\Concerns\HasAlignment;
use WellCMS\Tables\Columns\Column;
use WellCMS\Tables\Columns\Concerns\HasSpace;

class Stack extends Component
{
    use HasAlignment;
    use HasSpace;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.layout.stack';

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
