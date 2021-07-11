<?php

declare(strict_types=1);

namespace Parents\DataTransferObjects;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Parents\Requests\Request;
use Parents\Traits\SanitizerTrait;

abstract class ObjectData extends \Spatie\DataTransferObject\DataTransferObject
{
    use SanitizerTrait;

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
}
