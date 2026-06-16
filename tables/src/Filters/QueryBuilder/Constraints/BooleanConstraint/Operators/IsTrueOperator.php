<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint\Operators;

use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;

class IsTrueOperator extends Operator
{
    public function getName(): string
    {
        return 'isTrue';
    }

    public function getLabel(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.boolean.is_true.label.inverse' :
                'wellcms-tables::filters/query-builder.operators.boolean.is_true.label.direct',
        );
    }

    public function getSummary(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.boolean.is_true.summary.inverse' :
                'wellcms-tables::filters/query-builder.operators.boolean.is_true.summary.direct',
            ['attribute' => $this->getConstraint()->getAttributeLabel()],
        );
    }

    public function apply(Builder $query, string $qualifiedColumn): Builder
    {
        return $query->where($qualifiedColumn, ! $this->isInverse());
    }
}
