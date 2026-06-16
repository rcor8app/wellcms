<?php

namespace WellCMS\Tables\Actions;

use Exception;
use WellCMS\Actions\ActionGroup as BaseActionGroup;
use WellCMS\Actions\Concerns\InteractsWithRecord;
use WellCMS\Actions\Contracts\HasRecord;
use WellCMS\Tables\Actions\Contracts\HasTable;
use WellCMS\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array<Action | BulkAction> $actions
 */
class ActionGroup extends BaseActionGroup implements HasRecord, HasTable
{
    use InteractsWithRecord;

    protected Table $table;

    public function table(Table $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): Table
    {
        if (isset($this->table)) {
            return $this->table;
        }

        $group = $this->getGroup();

        if (! ($group instanceof HasTable)) {
            throw new Exception('This action does not belong to a table.');
        }

        return $group->getTable();
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'record' => [$this->getRecord()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $record = $this->getRecord();

        if (! $record) {
            return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
        }

        return match ($parameterType) {
            Model::class, $record::class => [$record],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
