<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Parents\Criterias\Criteria;

class CreatedTodayCriteria extends Criteria
{
    /**
     * @param  Builder              $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     */
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository): Builder
    {
        return $model->where('created_at', '>=', Carbon::today()->toDateString());
    }
}
