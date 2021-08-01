<?php

declare(strict_types=1);

namespace Domains\Children\Http\Controllers\Api;

use Domains\Children\Actions\DeleteChildAction;
use Domains\Children\Actions\GetAllChildrenAction;
use Domains\Children\Actions\GetChildByIdAction;
use Domains\Children\Actions\StoreChildAction;
use Domains\Children\Actions\UpdateChildAction;
use Domains\Children\DataTransferObjects\ChildData;
use Domains\Children\Http\Requests\Admin\DeleteChildRequest;
use Domains\Children\Http\Requests\Admin\IndexChildRequest;
use Domains\Children\Http\Requests\Admin\ShowChildRequest;
use Domains\Children\Http\Requests\Api\StoreChildApiRequest;
use Domains\Children\Http\Requests\Api\UpdateChildApiRequest;
use Domains\Children\Models\Child;
use Domains\Children\Transformers\ChildTransformer;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;
use Parents\Traits\RelationTrait;
use Symfony\Component\HttpFoundation\Response;

final class ChildApiController extends Controller
{
    use RelationTrait;

    protected string $relationClass = GetChildByIdAction::class;

    public function index(IndexChildRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var LengthAwarePaginator $children */
        $children = GetAllChildrenAction::run();

        return fractal(
            $children,
            new ChildTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Child::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(StoreChildApiRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var Child $child */
        $child = StoreChildAction::run(ChildData::fromRequest($request, 'data.attributes.'));
        return fractal(
            $child,
            new ChildTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Child::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_CREATED, [
                'Location' => route('api.children.show', [
                    'child' => $child->id
                ])
            ]);
    }

    public function show(ShowChildRequest $request, int $child): \Illuminate\Http\JsonResponse
    {
        return fractal(
            GetChildByIdAction::run($child),
            new ChildTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Child::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(UpdateChildApiRequest $request, int $child): \Illuminate\Http\JsonResponse
    {
        $childData = ChildData::fromRequest($request, 'data.attributes.');
        $childData->id = $child;

        return fractal(
            UpdateChildAction::run($childData),
            new ChildTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Child::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteChildRequest $request, int $child): \Illuminate\Http\Response
    {
        DeleteChildAction::run($child);

        return response()->noContent();
    }
}
