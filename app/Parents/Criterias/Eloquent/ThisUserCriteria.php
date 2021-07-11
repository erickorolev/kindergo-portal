<?php

namespace Parents\Criterias\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ThisUserCriteria extends Criteria
{
    /**
     * @var ?int
     */
    private ?int $userId;

    /**
     * ThisUserCriteria constructor.
     *
     * @param $userId
     */
    public function __construct(?int $userId = null)
    {
        if (!$userId) {
            $this->userId = (int) Auth::id();
        } else {
            $this->userId = $userId;
        }
    }

    /**
     * @param Builder                    $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where('user_id', '=', $this->userId);
    }
}
