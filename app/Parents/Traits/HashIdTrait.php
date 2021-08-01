<?php

declare(strict_types=1);

namespace Parents\Traits;

use Parents\Exceptions\IncorrectIdException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

use function is_null;
use function strtolower;

/**
 * Class HashIdTrait.
 */
trait HashIdTrait
{

    /**
     * endpoint to be skipped from decoding their ID's (example for external ID's)
     * @var  array
     */
    private array $skippedEndpoints = [
//        'orders/{id}/external',
    ];

    /**
     * Hashes the value of a field (e.g., ID)
     *
     * Will be used by the Eloquent Models (since it's used as trait there).
     *
     * @param ?string $field The field of the model to be hashed
     *
     * @return  mixed
     */
    public function getHashedKey(?string $field = null): mixed
    {
        // if no key is set, use the default key name (i.e., id)
        if ($field === null) {
            /** @psalm-var string $field */
            $field = $this->getKeyName();
        }

        // hash the ID only if hash-id enabled in the config
        if (Config::get('portal.hash-id')) {
            // we need to get the VALUE for this KEY (model field)
            /** @psalm-var int|string $value */
            $value = $this->getAttribute($field);
            return $this->encoder($value);
        }

        return $this->getAttribute($field);
    }

    /**
     * without decoding the encoded ID's you won't be able to use
     * validation features like `exists:table,id`
     *
     * @param array $requestData
     *
     * @return  array
     */
    protected function decodeHashedIdsBeforeValidation(array $requestData): array
    {
        // the hash ID feature must be enabled to use this decoder feature.
        if (Config::get('portal.hash-id') && isset($this->decode) && !empty($this->decode)) {
            // iterate over each key (ID that needs to be decoded) and call keys locator to decode them
            /** @var string $key */
            foreach ($this->decode as $key) {
                /** @var array $requestData */
                $requestData = $this->locateAndDecodeIds($requestData, $key);
            }
        }

        return $requestData;
    }

    /**
     * Search the IDs to be decoded in the request data
     *
     * @param array|string $requestData
     * @param string $key
     *
     * @return null|array|string
     */
    private function locateAndDecodeIds(array | string $requestData, string $key): array | null | string
    {
        // split the key based on the "."
        $fields = explode('.', $key);
        // loop through all elements of the key.
        $transformedData = $this->processField($requestData, $fields);

        return $transformedData;
    }

    /**
     * Recursive function to process (decode) the request data with a given key
     *
     * @param string|array $data
     * @param array $keysTodo
     *
     * @return null|array|string
     */
    private function processField(string | array $data, array $keysTodo): array | string | null
    {
        // check if there are no more fields to be processed
        if (empty($keysTodo)) {
            // there are no more keys left - so basically we need to decode this entry
            /** @psalm-suppress PossiblyInvalidArgument */
            $decodedId = $this->decode($data);
            return $decodedId;
        }

        // take the first element from the field
        /** @var string|int $field */
        $field = array_shift($keysTodo);

        //make sure field value is an array
        $data = is_array($data) ? $data : [$data];
        // is the current field an array?! we need to process it like crazy
        if ($field == '*') {
            // process each field of the array (and go down one level!)
            $fields = $data;
            /**
             * @var string|int $key
             * @var string $value
             */
            foreach ($fields as $key => $value) {
                $data[$key] = $this->processField($value, $keysTodo);
            }
            return $data;
        } else {
            // check if the key we are looking for does, in fact, really exist
            if (!array_key_exists($field, $data)) {
                return $data;
            }

            // go down one level
            /** @var string $value */
            $value = $data[$field];
            $data[$field] = $this->processField($value, $keysTodo);
            return $data;
        }
    }

    /**
     * @param array|string $subject
     * @param string|int $findKey
     * @param callable $callback
     *
     * @return  array|string
     */
    public function findKeyAndReturnValue(
        array | string &$subject,
        string | int $findKey,
        callable $callback
    ): string | array {
        // if the value is not an array, then you have reached the deepest point of the branch, so return the value.
        if (!is_array($subject)) {
            return $subject;
        }
        /**
         * @var string|int $key
         * @var string|array $value
         * @psalm-suppress MixedAssignment
         */
        foreach ($subject as $key => $value) {
            if ($key == $findKey && isset($subject[$findKey])) {
                $subject[$key] = $callback($subject[$findKey]);
                break;
            }

            // add the value with the recursive call
            $this->findKeyAndReturnValue($value, $findKey, $callback);
        }
        return $subject;
    }

    /**
     * @param array $ids
     *
     * @return  array
     */
    public function decodeArray(array $ids): array
    {
        $result = [];
        /** @var string $id */
        foreach ($ids as $id) {
            $result[] = $this->decode($id);
        }

        return $result;
    }

    /**
     * @param string | int | null    $id
     * @param ?string $parameter
     *
     * @return \null|array|string
     *
     * @throws IncorrectIdException
     *
     * @psalm-suppress MixedInferredReturnType
     */
    public function decode(string | int | null $id, ?string $parameter = null): array | string | null
    {
        // check if passed as null, (could be an optional decodable variable)
        $id = (string) $id;
        if (strtolower($id) == 'null') {
            return $id;
        }

        // check if is a number, to throw exception, since hashed ID should not be a number
        if (is_numeric($id)) {
            throw new IncorrectIdException(
                'Only Hashed ID\'s allowed' . (!is_null($parameter) ? " ($parameter)." : '.')
            );
        }

        // do the decoding if the ID looks like a hashed one
        return empty($this->decoder($id)) ? [] : $this->decoder($id)[0];
    }

    /**
     * @param string|int $id
     *
     * @return  mixed
     */
    public function encode(string | int $id): string
    {
        return $this->encoder($id);
    }

    /**
     * @param string $id
     *
     * @return  array
     */
    private function decoder(string $id): array
    {
        return Hashids::decode($id);
    }

    /**
     * @param $id
     *
     * @return  string
     */
    public function encoder(string | int $id): string
    {
        return Hashids::encode($id);
    }

    /**
     * Automatically decode any found `id` in the URL, no need to be used anymore.
     * Since now the user will define what needs to be decoded in the request.
     *
     * All ID's passed with all endpoints will be decoded before entering the Application
     */
    public function runHashedIdsDecoder(): void
    {
        if (Config::get('apiato.hash-id')) {
            /** @psalm-suppress MissingClosureParamType */
            Route::bind('id', function (string $id, $route) {
                // skip decoding some endpoints
                /** @psalm-suppress MixedMethodCall */
                if (!in_array($route->uri(), $this->skippedEndpoints)) {
                    // decode the ID in the URL
                    $decoded = $this->decoder($id);

                    if (empty($decoded)) {
                        throw new IncorrectIdException('ID (' . $id . ') is incorrect, consider using the hashed ID
                        instead of the numeric ID.');
                    }

                    return $decoded[0];
                }
            });
        }
    }
}
