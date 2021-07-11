<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface;

class CountCriteria extends \Parents\Criterias\Criteria
{
    private string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @psalm-param Builder $model
     * @inheritDoc
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        /** @var string $table */
        $table = $model->getModel()->getTable();
        return DB::table($table)
            ->select([$this->field, DB::raw('count(' . $this->field . ') as total_count')])
            ->groupBy($this->field);
    }
}
