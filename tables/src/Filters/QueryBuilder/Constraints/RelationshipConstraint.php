<?php

namespace WellCMS\Tables\Filters\QueryBuilder\Constraints;

use Closure;
use WellCMS\Support\Facades\WellCMSIcon;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\EqualsOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\HasMaxOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\HasMinOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsEmptyOperator;
use WellCMS\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;

class RelationshipConstraint extends Constraint
{
    protected bool | Closure $isMultiple = false;

    protected bool | Closure | null $canBeEmpty = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(WellCMSIcon::resolve('tables::filters.query-builder.constraints.relationship') ?? 'heroicon-m-arrows-pointing-out');

        $this->operators([
            HasMinOperator::make()
                ->visible(fn (): bool => $this->isMultiple()),
            HasMaxOperator::make()
                ->visible(fn (): bool => $this->isMultiple()),
            EqualsOperator::make()
                ->visible(fn (): bool => $this->isMultiple()),
            IsEmptyOperator::make()
                ->visible(fn (): bool => $this->canBeEmpty()),
        ]);
    }

    public function selectable(IsRelatedToOperator $operator): static
    {
        $this->unshiftOperators([$operator]);

        return $this;
    }

    public function multiple(bool | Closure $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->isMultiple);
    }

    public function emptyable(bool | Closure | null $condition = true): static
    {
        $this->canBeEmpty = $condition;

        return $this;
    }

    public function canBeEmpty(): bool
    {
        return $this->evaluate($this->canBeEmpty) ?? $this->isMultiple();
    }
}
