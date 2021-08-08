<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Controllers\Api;

use Domains\Trips\Actions\ReceiveTripFromCrmAction;
use Domains\Trips\Models\Trip;
use Domains\Trips\Transformers\TripTransformer;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;

final class ForceTripReceiveController extends Controller
{
    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        return fractal(
            ReceiveTripFromCrmAction::run($id),
            new TripTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Trip::RESOURCE_NAME)
            ->respondJsonApi();
    }
}
