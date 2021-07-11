<?php

declare(strict_types=1);

namespace Parents\Criterias\Eloquent;

use Parents\Criterias\Criteria;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrderByFieldCriteria
 *
 * @package App\Ship\Criterias\Eloquent
 */
class OrderByFieldCriteria extends Criteria
{

    private string $field;
    private string $sortOrder;

    /**
     * OrderByFieldCriteria constructor.
     *
     * @param string $field The field to be sorted
     * @param string $sortOrder the sort direction (asc or desc)
     */
    public function __construct(string $field, string $sortOrder)
    {
        $this->field = $field;

        $sortOrder = Str::lower($sortOrder);
        $availableDirections = [
            'asc',
            'desc',
        ];

        // check if the value is available, otherwise set "default" sort order to ascending!
        if (! array_search($sortOrder, $availableDirections)) {
            $sortOrder = 'asc';
        }

        $this->sortOrder = $sortOrder;
    }

    /**
     * @param Builder                                           $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->orderBy($this->field, $this->sortOrder);
    }
}
