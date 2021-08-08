<?php

declare(strict_types=1);

namespace Parents\DataTransferObjects;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Parents\Requests\Request;
use Parents\Traits\SanitizerTrait;
use Parents\ValueObjects\ValueObject;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\DataTransferObject;

abstract class ObjectData extends \Spatie\DataTransferObject\DataTransferObject
{
    use SanitizerTrait;

    public array $documents = [];

    protected static string $attribute_prefix = 'data.attributes.';

    public static function generateCarbonObject(?string $date): Carbon | false | null
    {
        if (!$date) {
            return null;
        }
        /** @var string $dateFormat */
        $dateFormat = config('panel.date_format');
        /** @var string $timeFormat */
        $timeFormat = config('panel.time_format');
        return \Illuminate\Support\Carbon::createFromFormat(
            $dateFormat . ' ' . $timeFormat,
            $date
        );
    }

    abstract public static function fromRequest(Request $request): self;

    public static function getRelatedData(array $data): Collection
    {
        if (!isset($data['data'])) {
            if (!empty($data) && isset($data[0])) {
                $result = collect([]);
                /** @var array $datum */
                foreach ($data as $datum) {
                    $result->push(['id' => $datum]);
                }
                return $result;
            }
            return collect([]);
        }
        return collect($data['data']);
    }

    protected function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                unset($array[$key]);
                continue;
            }
            if ($value instanceof ValueObject) {
                $array[$key] = $value;

                continue;
            }

            if ($value instanceof DataTransferObject) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (! is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
