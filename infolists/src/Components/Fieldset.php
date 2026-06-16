<?php

namespace WellCMS\Infolists\Components;

class Fieldset extends Component
{
    use Concerns\EntanglesStateWithSingularRelationship;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-infolists::components.fieldset';

    final public function __construct(string $label)
    {
        $this->label($label);
    }

    public static function make(string $label): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan('full');

        $this->columns(2);
    }
}
