<?php

declare(strict_types=1);

namespace Parents\Transformers;

use Domains\Users\Models\User;
use League\Fractal\Resource\Item;
use Parents\Foundation\Facades\Portal;
use League\Fractal\TransformerAbstract as FractalTransformer;
use Parents\Models\Model;

class Transformer extends \League\Fractal\TransformerAbstract
{
    /**
     * @return  ?User
     */
    public function user(): ?User
    {
        /** @var ?User $user */
        $user = Portal::call('Authentication@GetAuthenticatedUserTask');
        return $user;
    }

    /**
     * @param array $adminResponse
     * @param array $clientResponse
     *
     * @return  array
     */
    public function ifAdmin(array $adminResponse, array $clientResponse): array
    {
        /** @var ?User $user */
        $user = $this->user();

        if (!is_null($user) && $user->isSuperAdmin()) {
            return array_merge($clientResponse, $adminResponse);
        }

        return $clientResponse;
    }

    /**
     * @param mixed                       $data
     * @param callable|FractalTransformer $transformer
     * @param ?string                     $resourceKey
     *
     * @return Item
     * @psalm-suppress MixedMethodCall
     */
    public function item($data, $transformer, $resourceKey = null): Item
    {
        // set a default resource key if none is set
        if (!$resourceKey && $data) {
            /** @var ?string $resourceKey */
            $resourceKey = $data->getResourceKey();
        }

        return parent::item($data, $transformer, $resourceKey);
    }

    /**
     * @param  array  $data
     * @param  Model  $model
     * @return array
     * @psalm-suppress UnusedVariable
     */
    public function cleanAttributes(array $data, Model $model): array
    {
        $attr = $model->attributesToArray();
        /**
         * @var string $field
         * @var string $value */
        foreach ($data as $field => $value) {
            if (!array_key_exists($field, $attr) && $field !== 'id') {
                unset($data[$field]);
            }
            if ($field == 'id') {
                /** @var int $id */
                $id = $model->id;
                $data['id'] = $id;
            }
        }
        return $data;
    }

    public function getAvailableIncludes(): array
    {
        $original = parent::getAvailableIncludes();
        $configs = collect(config("jsonapi.resources.{$this->getCurrentScope()->getIdentifier()}.relationships"))
            ->map(function (array $relation) {
                /** @var array<string, string> $relation */
                return $relation['method'];
            })->toArray();
        return array_merge($original, $configs);
    }
}
