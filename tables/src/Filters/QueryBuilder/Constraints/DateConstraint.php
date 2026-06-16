<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints;

use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsAfterOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsBeforeOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsDateOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsMonthOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsYearOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\IsFilledOperator;

class DateConstraint extends Constraint
{
    use Concerns\CanBeNullable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(WellCMSIcon::resolve('tables::filters.query-builder.constraints.date') ?? 'heroicon-m-calendar');

        $this->operators([
            IsAfterOperator::class,
            IsBeforeOperator::class,
            IsDateOperator::class,
            IsMonthOperator::class,
            IsYearOperator::class,
            IsFilledOperator::make()
                ->visible(fn (): bool => $this->isNullable()),
        ]);
    }
}
