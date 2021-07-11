<?php

namespace Parents\Criterias\Eloquent;

use Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Query\Builder;

/**
 * Class ThisLikeThatCriteria
 *
 * @author Fabian Widmann <fabian.widmann@gmail.com>
 *
 * Retrieves all entities where $field contains one or more of the given items in $valueString.
 */
class ThisLikeThatCriteria extends Criteria
{

    /**
     * @var string name of the column
     */
    private string $field;

    /**
     * @var string contains values separated by $separator
     */
    private string $valueString;

    /**
     * @var string separates separate items in the given $values string. Default is csv.
     */
    private string $separator;

    /**
     * @var string this character is replaced with '%'. Default is *.
     */
    private string $wildcard;


    public function __construct(string $field, string $valueString, string $separator = ',', string $wildcard = '*')
    {
        $this->field = $field;
        $this->valueString = $valueString;
        $this->separator = $separator;
        $this->wildcard = $wildcard;
    }

    /**
     * Applies the criteria - if more than one value is separated by the configured separator we will "OR"
     * all the params.
     *
     * @param  Builder $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return  Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(function (Builder $query) {
            $values = explode($this->separator, $this->valueString);
            $query->where($this->field, 'LIKE', str_replace(
                $this->wildcard,
                '%',
                array_shift($values)
            ));
            foreach ($values as $value) {
                $query->orWhere($this->field, 'LIKE', str_replace($this->wildcard, '%', $value));
            }
        });
    }
}
