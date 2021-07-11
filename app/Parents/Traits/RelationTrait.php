<?php

declare(strict_types=1);

namespace Parents\Traits;

use Domains\Listings\Models\ListingCategory;
use Domains\Listings\Transformers\ListingProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Laratrust;
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
     */
    public function relations(int $id, string $relation): JsonResponse
    {
        abort_if(
            !Laratrust::isAbleTo(strtolower(Str::snake(Str::singular($relation))) . '_access'),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );
        /** @var ListingCategory $parentModel */
        $parentModel = Portal::call($this->relationClass, [$id]);
        /** @var \Illuminate\Support\Collection $data */
        $data = $parentModel->$relation;
        /** @var string $domain */
        $domain = $parentModel::DOMAIN_NAME;
        $classPrefix = Str::ucfirst(Str::singular($relation));
        /** @psalm-var class-string<Model> $childModel */
        if (class_exists('Domains\\' . Str::ucfirst($relation) . '\Transformers\\' . $classPrefix . 'Transformer')) {
            /** @psalm-var class-string<ListingProductTransformer> $transformerName */
            $transformerName = 'Domains\\' . Str::ucfirst($relation) . '\Transformers\\' . $classPrefix . 'Transformer';
            $childModel = 'Domains\\' . Str::ucfirst($relation) . '\Models\\' . $classPrefix;
        } else {
            /** @psalm-var class-string<ListingProductTransformer> $transformerName */
            $transformerName = 'Domains\\' . $domain . '\Transformers\\' . $classPrefix . 'Transformer';
            $childModel = 'Domains\\' . $domain . '\Models\\' . $classPrefix;
        }
        if (!class_exists($transformerName)) {
            /** @var string $correctRelation */
            $correctRelation = config('jsonapi.resources.' . Str::ucfirst($relation) . '.domain');
            /** @psalm-var class-string<ListingProductTransformer> $transformerName */
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
}
