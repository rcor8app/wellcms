<?php

namespace WellCMS\Forms\Components;

class Hidden extends Field
{
    /**
     * @var view-string
     */
    protected string $view = 'wellcms-forms::components.hidden';

    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan('hidden');
    }
}
