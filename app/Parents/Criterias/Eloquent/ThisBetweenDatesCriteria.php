<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Parents\Criterias\Criteria;
use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Query\Builder;

/**
 * Class ThisBetweenDatesCriteria
 *
 * Retrieves all entities whose date $field's value is between $start and $end.
 */
class ThisBetweenDatesCriteria extends Criteria
{

    /**
     * @var Carbon
     */
    private Carbon $start;

    /**
     * @var Carbon
     */
    private Carbon $end;

    /**
     * @var string
     */
    private string $field;


    public function __construct(string $field, Carbon $start, Carbon $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->field = $field;
    }

    /**
     * Applies the criteria
     *
     * @param Builder $model
     * @param         $repository
     *
     * @return        mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereBetween($this->field, [$this->start->toDateString(), $this->end->toDateString()]);
    }
}
