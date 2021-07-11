<?php

namespace Parents\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;
use Parents\QueryBuilder\FilterQueryBuilder;

trait HasAdvancedFilter
{
    public function scopeAdvancedFilter(Builder $query): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $limit = (int) request('limit', 10);
        return $this->processQuery($query, [
            'order_column'    => request('sort', 'id'),
            'order_direction' => request('order', 'desc'),
            'limit'           => request('limit', 10),
            's'               => request('s', null),
        ])
            ->paginate($limit);
    }

    /**
     * @param  Builder  $query
     * @param  array  $data
     * @return Builder
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function processQuery(Builder $query, array $data): Builder
    {
        $data = $this->processGlobalSearch($data);
        /** @var \Illuminate\Contracts\Validation\Validator $v */
        $v = validator()->make($data, [
            'order_column'    => 'sometimes|required|in:' . $this->orderableColumns(),
            'order_direction' => 'sometimes|required|in:asc,desc',
            'limit'           => 'sometimes|required|integer|min:1',
            's'               => 'sometimes|nullable|string',

            // advanced filter
            'filter_match' => 'sometimes|required|in:and,or',
            'f'            => 'sometimes|required|array',
            'f.*.column'   => 'required|in:' . $this->whiteListColumns(),
            'f.*.operator' => 'required_with:f.*.column|in:' . $this->allowedOperators(),
            'f.*.query_1'  => 'required',
            'f.*.query_2'  => 'required_if:f.*.operator,between,not_between',
        ]);

        if ($v->fails()) {
            throw new ValidationException($v);
        }
        /** @var array<string, array> $data */
        $data = $v->validated();

        return (new FilterQueryBuilder())->apply($query, $data);
    }

    protected function orderableColumns(): string
    {
        return implode(',', $this->orderable);
    }

    protected function whiteListColumns(): string
    {
        return implode(',', $this->filterable);
    }

    protected function allowedOperators(): string
    {
        return implode(',', [
            'contains',
        ]);
    }

    protected function processGlobalSearch(array $data): array
    {
        if (isset($data['f']) || !isset($data['s'])) {
            return $data;
        }

        $data['filter_match'] = 'or';

        $data['f'] = array_map(function ($column) use ($data) {
            return [
                'column'   => $column,
                'operator' => 'contains',
                'query_1'  => $data['s'],
            ];
        }, $this->filterable);

        return $data;
    }
}
