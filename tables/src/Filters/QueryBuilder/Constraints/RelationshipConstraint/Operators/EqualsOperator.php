<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators;

use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\TextInput;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;

class EqualsOperator extends Operator
{
    public function getName(): string
    {
        return 'equals';
    }

    public function getLabel(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.relationship.equals.label.inverse' :
                'wellcms-tables::filters/query-builder.operators.relationship.equals.label.direct',
        );
    }

    public function getSummary(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.relationship.equals.summary.inverse' :
                'wellcms-tables::filters/query-builder.operators.relationship.equals.summary.direct',
            [
                'relationship' => $this->getConstraint()->getAttributeLabel(),
                'count' => $this->getSettings()['count'],
            ],
        );
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('count')
                ->label(__('wellcms-tables::filters/query-builder.operators.relationship.form.count.label'))
                ->numeric()
                ->required()
                ->minValue(1),
        ];
    }

    public function applyToBaseQuery(Builder $query): Builder
    {
        return $query->has($this->getConstraint()->getRelationshipName(), $this->isInverse() ? '!=' : '=', intval($this->getSettings()['count']));
    }
}
