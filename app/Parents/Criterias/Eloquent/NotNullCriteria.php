<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NotNullCriteria extends \Parents\Criterias\Criteria
{
    private string $field;

    /**
     * ThisFieldCriteria constructor.
     *
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param  Builder                   $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return  Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereNotNull($this->field);
    }
}
