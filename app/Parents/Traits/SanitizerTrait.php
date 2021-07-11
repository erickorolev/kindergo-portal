<?php

declare(strict_types=1);

namespace Parents\Traits;

use Illuminate\Support\Arr;
use Parents\DataTransferObjects\ObjectData;
use Parents\Exceptions\InternalErrorException;
use Parents\Requests\Request;

trait SanitizerTrait
{

    /**
     * Sanitizes the data of a request. This is a superior version of php built-in array_filter() as it preserves
     * FALSE and NULL values as well.
     *
     * @param array $fields a list of fields to be checked in the Dot-Notation (e.g., ['data.name', 'data.description'])
     *
     * @return array an array containing the values if the field was present in the request and the intersection array
     */
    public function sanitizeInput(array $fields): array
    {
        $data = $this->getData();

        $search = [];
        /** @var string|null $field */
        foreach ($fields as $field) {
            // create a multidimensional array based on $fields
            // which was submitted as DOT notation (e.g., data.name)
            Arr::set($search, $field, true);
        }

        // check, if the keys exist in both arrays
        $data = $this->recursiveArrayIntersectKey($data, $search);

        return $data;
    }

    /**
     * @return array
     * @throws InternalErrorException
     */
    private function getData(): array
    {
        // get all request data
        if ($this instanceof ObjectData) {
            $data = $this->toArray();
        } elseif ($this instanceof Request) {
            $data = $this->all();
        } else {
            throw new InternalErrorException('Unsupported class type for sanitization.');
        }

        return $data;
    }

    /**
     * Recursively intersects 2 arrays based on their keys.
     *
     * @param array $a first array (that keeps the values)
     * @param array $b second array to be compared with
     *
     * @return array an array containing all keys that are present in $a and $b. Only values from $a are returned
     */
    private function recursiveArrayIntersectKey(array $a, array $b): array
    {
        $a = array_intersect_key($a, $b);
        /**
         * @var string|int $key
         * @var array|string $value
         */
        foreach ($a as $key => &$value) {
            if (is_array($value) && is_array($b[$key])) {
                $value = $this->recursiveArrayIntersectKey($value, $b[$key]);
            }
        }

        return $a;
    }
}
