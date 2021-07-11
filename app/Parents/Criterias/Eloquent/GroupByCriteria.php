<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class GroupByCriteria extends \Parents\Criterias\Criteria
{
    private string $field;

    /**
     * ThisFieldCriteria constructor.
     *
     * @param $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param  Builder                                          $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->groupBy($this->field);
    }
}
