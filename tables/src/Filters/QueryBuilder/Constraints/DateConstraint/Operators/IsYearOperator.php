<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators;

use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\TextInput;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;

class IsYearOperator extends Operator
{
    public function getName(): string
    {
        return 'isYear';
    }

    public function getLabel(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.date.is_year.label.inverse' :
                'wellcms-tables::filters/query-builder.operators.date.is_year.label.direct',
        );
    }

    public function getSummary(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.date.is_year.summary.inverse' :
                'wellcms-tables::filters/query-builder.operators.date.is_year.summary.direct',
            [
                'attribute' => $this->getConstraint()->getAttributeLabel(),
                'year' => $this->getSettings()['year'],
            ],
        );
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('year')
                ->label(__('wellcms-tables::filters/query-builder.operators.date.form.year.label'))
                ->integer()
                ->required(),
        ];
    }

    public function apply(Builder $query, string $qualifiedColumn): Builder
    {
        return $query->whereYear($qualifiedColumn, $this->isInverse() ? '!=' : '=', $this->getSettings()['year']);
    }
}
