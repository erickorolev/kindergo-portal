<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrderByCreationDateAscendingCriteria.
 *
 */
class OrderByCreationDateAscendingCriteria extends Criteria
{

    /**
     * @param  Builder                                         $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->orderBy('created_at', 'asc');
    }
}
