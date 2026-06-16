<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators;

use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\DatePicker;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class IsAfterOperator extends Operator
{
    public function getName(): string
    {
        return 'isAfter';
    }

    public function getLabel(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.date.is_after.label.inverse' :
                'wellcms-tables::filters/query-builder.operators.date.is_after.label.direct',
        );
    }

    public function getSummary(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.date.is_after.summary.inverse' :
                'wellcms-tables::filters/query-builder.operators.date.is_after.summary.direct',
            [
                'attribute' => $this->getConstraint()->getAttributeLabel(),
                'date' => Carbon::parse($this->getSettings()['date'])->toFormattedDateString(),
            ],
        );
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [
            DatePicker::make('date')
                ->label(__('wellcms-tables::filters/query-builder.operators.date.form.date.label'))
                ->required(),
        ];
    }

    public function apply(Builder $query, string $qualifiedColumn): Builder
    {
        return $query->whereDate($qualifiedColumn, $this->isInverse() ? '<' : '>=', $this->getSettings()['date']);
    }
}
