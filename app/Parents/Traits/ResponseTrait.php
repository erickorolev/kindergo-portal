<?php

namespace Parents\Traits;

use Parents\Transformers\Transformer;
use Parent\Exceptions\InvalidTransformerException;
use Fractal;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use ReflectionClass;
use Request;

/**
 * Class ResponseTrait
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
trait ResponseTrait
{

    /**
     * @var  array
     */
    protected array $metaData = [];

    /**
     * @param mixed $data
     * @param Transformer|string|null  $transformerName The transformer (e.g., Transformer::class or new Transformer())
     * to be applied
     * @param array $includes additional resources to be included
     * @param array $meta additional meta information to be applied
     * @param mixed $resourceKey the resource key to be set for the TOP LEVEL resource
     *
     * @return array
     */
    public function transform(
        mixed $data,
        Transformer|string|null $transformerName = null,
        array $includes = [],
        array $meta = [],
        mixed $resourceKey = null
    ): array {
        // first, we need to create the transformer
        if ($transformerName instanceof Transformer) {
            // check, if we have provided a respective TRANSFORMER class
            $transformer = $transformerName;
        } else {
            // of if we just passed the classname
            $transformer = new $transformerName();
        }

        // now, finally check, if the class is really a TRANSFORMER
        if (! ($transformer instanceof Transformer)) {
            throw new InvalidTransformerException();
        }

        // add specific meta information to the response message
        $this->metaData = [
            'include' => $transformer->getAvailableIncludes(),
            'custom'  => $meta,
        ];

        // no resource key was set
        if (!$resourceKey) {
            // get the resource key from the model
            $obj = null;
            if ($data instanceof AbstractPaginator) {
                $obj = $data->getCollection()->first();
            } elseif ($data instanceof Collection) {
                $obj = $data->first();
            } else {
                $obj = $data;
            }

            // if we have an object, try to get its resourceKey
            if ($obj) {
                $resourceKey = $obj->getResourceKey();
            }
        }

        $fractal = Fractal::create($data, $transformer)->withResourceName($resourceKey)->addMeta($this->metaData);

        // read includes passed via query params in url
        $requestIncludes = $this->parseRequestedIncludes();

        // merge the requested includes with the one added by the transform() method itself
        $requestIncludes = array_unique(array_merge($includes, $requestIncludes));

        // and let fractal include everything
        $fractal->parseIncludes($requestIncludes);

        // apply request filters if available in the request
        if ($requestFilters = Request::get('filter')) {
            $result = $this->filterResponse($fractal->toArray(), explode(';', $requestFilters));
        } else {
            $result = $fractal->toArray();
        }

        return $result;
    }


    /**
     * @param $data
     *
     * @return  $this
     */
    public function withMeta($data): self
    {
        $this->metaData = $data;

        return $this;
    }

    /**
     * @param       $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function json($message, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return new JsonResponse($message, $status, $headers, $options);
    }

    /**
     * @param null  $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return JsonResponse
     */
    public function created($message = null, int $status = 201, array $headers = [], int $options = 0): JsonResponse
    {
        return new JsonResponse($message, $status, $headers, $options);
    }

    /**
     * @param null  array or string $message
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function accepted($message = null, $status = 202, array $headers = [], $options = 0): JsonResponse
    {
        return new JsonResponse($message, $status, $headers, $options);
    }

    /**
     * @param $responseArray
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function deleted($responseArray = null): JsonResponse
    {
        if (!$responseArray) {
            return $this->accepted();
        }

        $id = $responseArray->getHashedKey();
        $className = (new ReflectionClass($responseArray))->getShortName();

        return $this->accepted([
            'message' => "$className ($id) Deleted Successfully.",
        ]);
    }

    /**
     * @param int $status
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function noContent($status = 204): JsonResponse
    {
        return new JsonResponse(null, $status);
    }


    /**
     * @param array $responseArray
     * @param array $filters
     *
     * @return array
     */
    private function filterResponse(array $responseArray, array $filters): array
    {
        foreach ($responseArray as $k => $v) {
            if (in_array($k, $filters, true)) {
                // we have found our element - so continue with the next one
                continue;
            }

            if (is_array($v)) {
                // it is an array - so go one step deeper
                $v = $this->filterResponse($v, $filters);
                if (empty($v)) {
                    // it is an empty array - delete the key as well
                    unset($responseArray[$k]);
                } else {
                    $responseArray[$k] = $v;
                }
                continue;
            } else {
                // check if the array is not in our filter-list
                if (!in_array($k, $filters)) {
                    unset($responseArray[$k]);
                    continue;
                }
            }
        }

        return $responseArray;
    }

    /**
     * @return array
     */
    protected function parseRequestedIncludes(): array
    {
        return explode(',', Request::get('include'));
    }
}
