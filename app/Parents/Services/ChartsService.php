<?php

declare(strict_types=1);

namespace Parents\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JsonSerializable;
use Parents\Models\Model;

/**
 * Class ChartsService
 * @package Parents\Services
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ChartsService implements Arrayable, Jsonable, JsonSerializable
{
    /** @var string[]  */
    public const GROUP_PERIODS = [
        'day'   => 'Y-m-d',
        'week'  => 'Y-W',
        'month' => 'Y-m',
        'year'  => 'Y',
    ];
    protected array $options;
    protected array $attributes;

    protected string $type;
    protected Model $model;

    protected string $group_by_field;
    protected string $group_by_period;

    protected string $filter_by_field;
    protected string $filter_by_period;

    protected array $usedColors = [];
    protected string $colorSet;

    /**
     * ChartsService constructor.
     * @param  array  $options
     * @throws Exception
     * @psalm-suppress MixedAssignment
     * @psalm-suppress PropertyTypeCoercion
     * @psalm-suppress MixedMethodCall
     */
    public function __construct(array $options)
    {
        $this->options    = $options;
        $this->attributes = [];

        $this->validate($this->options);

        $this->type  = $this->options['chart_type'];
        $this->model = new $this->options['model']();

        $this->group_by_field  = data_get($this->options, 'group_by_field', null);
        $this->group_by_period = (string) data_get($this->options, 'group_by_period', null);

        $this->filter_by_field  = data_get($this->options, 'filter_by_field', null);
        $this->filter_by_period = data_get($this->options, 'filter_by_period', null);

        $this->make();
    }

    /**
     * @param Collection|array|int|string $value
     * @psalm-suppress MixedAssignment
     */
    public function setAttr(string $key, array|string|int|Collection $value): void
    {
        data_set($this->attributes, $key, $value);
    }

    public function toArray(): array
    {
        return array_merge($this->attributesToArray());
    }

    public function attributesToArray(): array
    {
        return $this->attributes;
    }

    public function toJson($options = 0): bool|string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    protected function validate(array $options): void
    {
        $rules = [
            'title'            => 'required|bail',
            'chart_type'       => 'required|in:bar,line,pie,stats,latest|bail',
            'model'            => 'required|bail',
            'filter_by_field'  => 'sometimes|string|bail',
            'filter_by_period' => 'required_with:filter_by_field|string|bail',
            'group_by_field'   => 'required_if:chart_type,bar,line,pie|string|bail',
            'group_by_period'  => 'required_with:group_by_field|in:day,week,month,year|bail',
            'footer_icon'      => 'sometimes|string|bail',
            'footer_text'      => 'sometimes|string|bail',
            'limit'            => 'required_if:chart_type,latest|integer|bail',
            'fields'           => 'sometimes|array|bail',
            'fields.*'         => 'string',
            'icon'             => 'sometimes|string|bail',
            'color'            => 'sometimes|string|bail',
            'legend'           => 'sometimes|string|bail',
            'column_class'     => 'sometimes|string|bail',
            'chartjs_options'  => 'sometimes|array|bail',
        ];

        if (isset($this->options['filter_by_period'])) {
            $type = gettype($options['filter_by_period']);
            if ($type === 'integer') {
                $rules['filter_by_period'] = 'required|integer|bail';
            } else {
                $rules['filter_by_period'] = 'required|in:week,month,year|bail';
            }
        }

        $validator = Validator::make($options, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    protected function make(): void
    {
        /** @var string $title */
        $title = $this->options['title'];
        $this->setAttr('title', $title);
        $this->setAttr('type', ucfirst($this->type));
        $this->setAttr('icon', $this->getIcon());
        $this->setAttr('column_class', $this->getColumnClass());

        if (in_array($this->type, ['line', 'bar', 'pie'])) {
            $this->handleChartjsCharts();
        }

        if ($this->type === 'stats') {
            $this->handleStatsCard();
        }

        if ($this->type === 'latest') {
            $this->handleLatestEntries();
        }
    }

    /**
     * @psalm-suppress UnusedVariable
     */
    protected function handleLatestEntries(): void
    {
        $query  = $this->getQuery();
        /** @var array $fields */
        $fields = data_get($this->options, 'fields', []);
        /** @var string $field */
        foreach ($fields as $field) {
            if ($this->isNestedColumn($field)) {
                [$relation, $column] = explode('.', $field);
                $query->with($relation);
            }
        }
        $limit = (int) $this->options['limit'];
        $collection = $query->latest()
            ->take($limit)
            ->get();

        $this->setAttr('data', $collection);
        $this->setAttr('fields', $fields);
    }

    protected function isNestedColumn(string $column): bool
    {
        return strpos($column, '.') !== false;
    }

    protected function handleStatsCard(): void
    {
        /** @var string $icon */
        $icon = data_get($this->options, 'footer_icon', '');
        /** @var string $text */
        $text = data_get($this->options, 'footer_text', '');
        $this->setAttr('footer_icon', $icon);
        $this->setAttr('footer_text', $text);
        $this->setAttr('data', $this->getQuery()->count());
    }

    protected function getQuery(): Builder
    {
        /** @var Builder $result */
        $result = $this->model::when($this->filter_by_field && $this->filter_by_period, function (Builder $q) {
            return $q->where($this->filter_by_field, '>=', $this->getFilterByPeriod());
        });
        return $result;
    }

    /**
     * @psalm-suppress all
     */
    protected function handleChartjsCharts(): void
    {
        $this->setAttr('options', $this->getChartjsOptions());
        /** @var array<array-key, mixed> $dataset */
        $dataset    = [];
        $collection = $this->getQuery()->get();

        if (!$collection->count()) {
            return;
        }

        $this->applyGroupBy($collection)
            ->each(function ($item, $key) use (&$dataset) {
                $dataset['labels'][] = $key;
                $dataset['series'][] = $item->count($this->group_by_field);
            });

        $this->setSeries($dataset);
    }

    /**
     * @param  Collection  $collection
     * @return Collection
     * @psalm-suppress MixedPropertyFetch
     */
    protected function applyGroupBy(Collection $collection): Collection
    {
        return $collection->sortBy($this->group_by_field)
            ->groupBy(function (Model $item) {
                if ($this->isDateField($this->group_by_field)) {
                    if (is_null($item->{$this->group_by_field})) {
                        return 'NULL';
                    }
                    /** @var Carbon $itemField */
                    $itemField = $item->{$this->group_by_field};
                    return $itemField->format($this->getGroupByPeriod());
                }
                if ($this->isNestedColumn($this->group_by_field)) {
                    [$relation, $column] = explode('.', $this->group_by_field);
                    /** @var string $result */
                    $result = $item->{$relation}->{$column};
                    return $result;
                }
                if (is_null($item->{$this->group_by_field})) {
                    return 'NULL';
                }

                return $item->{$this->group_by_field};
            });
    }

    protected function setSeries(array $dataset): void
    {
        /** @var array $labelsData */
        $labelsData = $dataset['labels'];
        $this->setAttr('labels', $labelsData);
        /** @var string $title */
        $title = $this->options['title'];
        if ($this->type === 'bar') {
            $this->setAttr('datasets', [[
                'label'           => $this->getLegend(),
                'backgroundColor' => $this->getColor($title),
                'data'            => $dataset['series'],
            ]]);
        } elseif ($this->type === 'line') {
            $this->setAttr('datasets', [[
                'label'       => $this->getLegend(),
                'fill'        => false,
                'borderColor' => $this->getColor($title),
                'data'        => $dataset['series'],
            ]]);
        } elseif ($this->type === 'pie') {
            $background_colors = [];
            /** @var string $label */
            foreach ($dataset['labels'] as $label) {
                $background_colors[] = $this->getColor($label);
            }

            $this->setAttr('datasets', [[
                'data'            => $dataset['series'],
                'backgroundColor' => $background_colors,
            ]]);
        }
    }

    protected function getChartjsOptions(): array
    {
        if (isset($this->options['chartjs_options'])) {
            /** @var array $opts */
            $opts = $this->options['chartjs_options'];
            return $opts;
        }
        if (in_array($this->type, ['line', 'bar'], true)) {
            return [
                'height' => 300,
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ]],
                ],
                'responsive'          => true,
                'maintainAspectRatio' => false,
            ];
        }
        if ($this->type === 'pie') {
            return [
                'responsive'          => true,
                'maintainAspectRatio' => false,
            ];
        }

        return [];
    }

    protected function getColumnClass(): string
    {
        /** @var string $class */
        $class = data_get($this->options, 'column_class', 'col-md-12');
        return $class;
    }

    protected function getLegend(): string
    {
        /** @var string $legend */
        $legend = data_get($this->options, 'legend', 'Count');
        return $legend;
    }

    protected function getIcon(): string
    {
        if (isset($this->options['chart_icon'])) {
            /** @var string $chartIcon */
            $chartIcon = $this->options['chart_icon'];
            return $chartIcon;
        }
        if ($this->type === 'bar') {
            return 'bar_chart';
        }
        if ($this->type === 'line') {
            return 'multiline_chart';
        }
        if ($this->type === 'pie') {
            return 'pie_chart';
        }
        if ($this->type === 'stats') {
            return 'trending_up';
        }
        if ($this->type === 'latest') {
            return 'table_chart';
        }

        return 'show_chart';
    }

    /**
     * @param  string  $value
     * @return string
     * @psalm-suppress InvalidPropertyAssignmentValue
     * @psalm-suppress InvalidArrayOffset
     */
    protected function getColor(string $value): string
    {
        if (isset($this->options['chart_color'])) {
            /** @var string $color */
            $color = $this->options['chart_color'];
            return $color;
        }

        $allColors = [
            '300' => ['#e57373', '#f06292', '#ba68c8', '#7986cb',
                '#64b5f6', '#4dd0e1', '#4db6ac', '#81c784', '#fff176', '#ffb74d', '#a1887f', '#e0e0e0'],
            '500' => ['#f44336', '#e91e63', '#9c27b0', '#3f51b5',
                '#2196f3', '#673ab7', '#009688', '#4caf50', '#ffeb3b', '#ff9800', '#795548', '#9e9e9e'],
            '700' => ['#d32f2f', '#c2185b', '#7b1fa2', '#303f9f',
                '#1976d2', '#0097a7', '#00796b', '#388e3c', '#fbc02d', '#f57c00', '#5d4037', '#616161'],
        ];

        if (!$this->colorSet) {
            $this->colorSet = array_keys($allColors)[0];
        }
        /** @var array<array-key, mixed> $currentColors */
        $currentColors = $allColors[$this->colorSet];

        if (count($this->usedColors) === count($currentColors)) {
            $this->usedColors = [];
            $sets             = array_keys($allColors);
            $foundColors = (int) array_search($this->colorSet, $sets);
            $this->colorSet   = $sets[($foundColors + 1) % count($sets)];
            /** @var array<array-key, mixed> $currentColors */
            $currentColors    = $allColors[$this->colorSet];
        }
        /** @var string[] $colors */
        $colors = array_values(array_diff($currentColors, $this->usedColors));

        $hash = 0;
        foreach (str_split($value) as $c) {
            $hash = ord($c) + (($hash << 5) - $hash);
        }

        $index              = abs(($hash) % count($colors));
        $pickedColor        = $colors[$index];
        $this->usedColors[] = $pickedColor;

        return $pickedColor;
    }

    protected function getGroupByPeriod(): string
    {
        /** @var array<string, string> $groups */
        $groups = static::GROUP_PERIODS;
        return $groups[$this->group_by_period];
    }

    protected function getFilterByPeriod(): \Illuminate\Support\Carbon|string
    {
        if ($this->filter_by_period === 'week') {
            return date('Y-m-d', strtotime('last Monday'));
        }
        if ($this->filter_by_period === 'month') {
            return date('Y-m') . '-01';
        }
        if ($this->filter_by_period === 'year') {
            return date('Y') . '-01-01';
        }
        $period = (int) $this->filter_by_period;

        return now()->startOfDay()->subDays($period - 1);
    }

    protected function isDateField(string $field): bool
    {
        $date_fields = $this->model->getDates();

        return in_array($this->group_by_field, $date_fields, true);
    }
}
