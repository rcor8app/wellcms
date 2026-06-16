<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators;

use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\TextInput;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;

class HasMinOperator extends Operator
{
    public function getName(): string
    {
        return 'hasMin';
    }

    public function getLabel(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.relationship.has_min.label.inverse' :
                'wellcms-tables::filters/query-builder.operators.relationship.has_min.label.direct',
        );
    }

    public function getSummary(): string
    {
        return __(
            $this->isInverse() ?
                'wellcms-tables::filters/query-builder.operators.relationship.has_min.summary.inverse' :
                'wellcms-tables::filters/query-builder.operators.relationship.has_min.summary.direct',
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
        return $query->has($this->getConstraint()->getRelationshipName(), $this->isInverse() ? '<' : '>=', intval($this->getSettings()['count']));
    }
}
