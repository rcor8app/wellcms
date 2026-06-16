<?php

namespace WellCMS\Infolists\Components;

use Closure;
use WellCMS\Support\Concerns\HasFromBreakpoint;
use WellCMS\Support\Concerns\HasVerticalAlignment;

class Split extends Component
{
    use HasFromBreakpoint;
    use HasVerticalAlignment;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-infolists::components.split';

    /**
     * @param  array<Component> | Closure  $schema
     */
    final public function __construct(array | Closure $schema)
    {
        $this->schema($schema);
    }

    /**
     * @param  array<Component> | Closure  $schema
     */
    public static function make(array | Closure $schema): static
    {
        $static = app(static::class, ['schema' => $schema]);
        $static->configure();

        return $static;
    }
}
