<?php

declare(strict_types=1);

namespace Parents\QueryBuilder;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Parents\Models\Model;

/**
 * Class FilterQueryBuilder
 * @package Parents\QueryBuilder
 * @psalm-suppress MissingConstructor
 */
class FilterQueryBuilder
{
    protected Model $model;
    protected string $table;

    /**
     * @param  Builder  $query
     * @param  array<string, array>  $data
     * @return Builder
     * @psalm-suppress InvalidArgument
     */
    public function apply(Builder $query, array $data): Builder
    {
        /** @var Model $model */
        $model = $query->getModel();
        $this->model = $model;
        $this->table = $this->model->getTable();

        if (isset($data['f'])) {
            /** @var array<string, string> $filter */
            foreach ($data['f'] as $filter) {
                /** @var ?string $filmatch */
                $filmatch = $data['filter_match'];
                $filter['match'] = $filmatch ?? 'and';
                $this->makeFilter($query, $filter);
            }
        }

        $this->makeOrder($query, $data);

        return $query;
    }

    /**
     * @param  array<string, string>  $filter
     * @param  Builder  $query
     * @return Builder
     */
    public function contains(array $filter, Builder $query): Builder
    {
        return $query->where($filter['column'], 'like', '%' . $filter['query_1'] . '%', $filter['match']);
    }

    /**
     * @param  Builder  $query
     * @param  array<string, string>  $data
     * @return void
     * @psalm-suppress TypeDoesNotContainType
     */
    protected function makeOrder(Builder $query, array $data): void
    {
        if ($this->isNestedColumn($data['order_column'])) {
            [$relationship, $column] = explode('.', $data['order_column']);
            $callable                = Str::camel($relationship);
            /** @var BelongsTo $belongs */
            $belongs                 = $this->model->{$callable}();
            /** @var Model $relatedModel */
            $relatedModel            = $belongs->getModel();
            $relatedTable            = $relatedModel->getTable();
            $as                      = "prefix_{$relatedTable}";

            if (!$belongs instanceof BelongsTo) {
                return;
            }

            $query->leftJoin(
                "{$relatedTable} as {$as}",
                "{$as}.id",
                '=',
                "{$this->table}.{$relationship}_id"
            );

            $data['order_column'] = "{$as}.{$column}";
        }

        $query
            ->orderBy($data['order_column'], $data['order_direction'])
            ->select("{$this->table}.*");
    }

    /**
     * @param  Builder  $query
     * @param  array<string, string>  $filter
     * @return void
     */
    protected function makeFilter(Builder $query, array $filter): void
    {
        if ($this->isNestedColumn($filter['column'])) {
            [$relation, $filter['column']] = explode('.', $filter['column']);
            $callable                      = Str::camel($relation);
            $filter['match']               = 'and';

            $query->orWhereHas(Str::camel($callable), function (Builder $q) use ($filter) {
                $this->{Str::camel($filter['operator'])}($filter, $q);
            });
        } else {
            $filter['column'] = "{$this->table}.{$filter['column']}";
            $this->{Str::camel($filter['operator'])}($filter, $query);
        }
    }

    protected function isNestedColumn(string $column): bool
    {
        return strpos($column, '.') !== false;
    }
}
