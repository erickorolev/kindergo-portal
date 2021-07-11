<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ThisEqualThatCriteria
 *
 */
class ThisEqualThatCriteria extends Criteria
{

    /**
     * @var
     */
    private string $field;

    /**
     * @var
     */
    private string $value;

    /**
     * ThisEqualThatCriteria constructor.
     *
     * @param $field
     * @param $value
     */
    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param Builder                                           $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return  mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where($this->field, $this->value);
    }
}
