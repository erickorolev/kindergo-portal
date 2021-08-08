<?php

declare(strict_types=1);

namespace Domains\Children\Http\Controllers\Api;

use Domains\Children\Actions\ReceiveChildFromCrmAction;
use Domains\Children\Models\Child;
use Domains\Children\Transformers\ChildTransformer;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;

final class ForceChildReceiveController extends Controller
{
    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        return fractal(
            ReceiveChildFromCrmAction::run($id),
            new ChildTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Child::RESOURCE_NAME)
            ->respondJsonApi();
    }
}
