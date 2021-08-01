<?php

declare(strict_types=1);

namespace Parents\Traits;

use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use League\Fractal\Serializer\JsonApiSerializer;
use Parents\Exceptions\UndefinedTransporterException;
use Parents\Foundation\Facades\Portal;
use Parents\Models\Model;
use Symfony\Component\HttpFoundation\Response;

trait RelationTrait
{
    /**
     * @return JsonResponse
     * @psalm-suppress UnsafeInstantiation
     * @psalm-suppress InvalidStringClass
     */
    public function relations(int $id, string $relation): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(
            $user->cant('list ' . $relation),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );
        /** @var User $parentModel */
        $parentModel = $this->relationClass::run($id);
        /** @var \Illuminate\Support\Collection $data */
        $data = $parentModel->$relation;
        /** @var string $domain */
        $domain = $parentModel::DOMAIN_NAME;
        $classPrefix = Str::ucfirst(Str::singular($relation));
        /** @psalm-var class-string<Model> $childModel */
        if (class_exists('Domains\\' . Str::ucfirst($relation) . '\Transformers\\' . $classPrefix . 'Transformer')) {
            /** @psalm-var class-string<UserTransformer> $transformerName */
            $transformerName = 'Domains\\' . Str::ucfirst($relation) . '\Transformers\\' . $classPrefix . 'Transformer';
            $childModel = 'Domains\\' . Str::ucfirst($relation) . '\Models\\' . $classPrefix;
        } else {
            /** @psalm-var class-string<UserTransformer> $transformerName */
            $transformerName = 'Domains\\' . $domain . '\Transformers\\' . $classPrefix . 'Transformer';
            $childModel = 'Domains\\' . $domain . '\Models\\' . $classPrefix;
        }
        if (!class_exists($transformerName)) {
            /** @var ?string $correctRelation */
            $correctRelation = config('jsonapi.resources.' . Str::plural($relation) . '.domain');
            /** @psalm-var class-string<UserTransformer> $transformerName */
            $transformerName = 'Domains\\' . $correctRelation . '\Transformers\\' . $classPrefix . 'Transformer';
            $childModel = 'Domains\\' . $correctRelation . '\Models\\' . $classPrefix;
        }
        if (!class_exists($transformerName)) {
            throw new UndefinedTransporterException('Transformer with name not found: ' . $transformerName);
        }
        /** @var string $resourceName */
        $resourceName = $childModel::RESOURCE_NAME;
        return fractal(
            $data,
            new $transformerName(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName($resourceName)
            ->respondJsonApi();
    }

    /**
     * @param  int  $id
     * @param  string  $relation
     * @param  int  $parent
     * @return \Illuminate\Http\Response
     * @psalm-suppress InvalidStringClass
     */
    public function relationCreate(int $id, string $relation, int $parent): \Illuminate\Http\Response
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(
            $user->cant('update ' . $relation),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );
        /** @var User $parentModel */
        $parentModel = $this->relationClass::run($id);
        $parentModel->$relation()->syncWithoutDetaching([$parent]);
        return response()->noContent();
    }
}
