<?php

declare(strict_types=1);


namespace Domains\Users\Http\Controllers\Api;

use Domains\Users\Actions\ReceiveUserFromCrmAction;
use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;

final class ForceUserReceiveController extends Controller
{
    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        return fractal(
            ReceiveUserFromCrmAction::run($id),
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi();
    }
}
