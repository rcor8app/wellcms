<?php

namespace WellCMS\Tables\Columns;

class ColorColumn extends Column
{
    use Concerns\CanBeCopied;
    use Concerns\CanWrap;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-tables::columns.color-column';
}
