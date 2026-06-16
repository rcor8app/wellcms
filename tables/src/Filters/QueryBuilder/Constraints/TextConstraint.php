<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints;

use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\IsFilledOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\TextConstraint\Operators\ContainsOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\TextConstraint\Operators\EndsWithOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\TextConstraint\Operators\EqualsOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\TextConstraint\Operators\StartsWithOperator;

class TextConstraint extends Constraint
{
    use Concerns\CanBeNullable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(WellCMSIcon::resolve('tables::filters.query-builder.constraints.text') ?? 'heroicon-m-language');

        $this->operators([
            ContainsOperator::class,
            StartsWithOperator::class,
            EndsWithOperator::class,
            EqualsOperator::class,
            IsFilledOperator::make()
                ->visible(fn (): bool => $this->isNullable()),
        ]);
    }
}
