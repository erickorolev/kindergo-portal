<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Controllers\Api;

use Domains\Trips\Actions\DeleteTripAction;
use Domains\Trips\Actions\GetAllTripsAction;
use Domains\Trips\Actions\GetTripByIdAction;
use Domains\Trips\Actions\StoreTripAction;
use Domains\Trips\Actions\UpdateTripAction;
use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Http\Requests\Admin\DeleteTripRequest;
use Domains\Trips\Http\Requests\Admin\IndexTripsRequest;
use Domains\Trips\Http\Requests\Admin\ShowTripRequest;
use Domains\Trips\Http\Requests\Api\TripStoreApiRequest;
use Domains\Trips\Http\Requests\Api\TripUpdateApiRequest;
use Domains\Trips\Models\Trip;
use Domains\Trips\Transformers\TripTransformer;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;
use Parents\Traits\RelationTrait;
use Symfony\Component\HttpFoundation\Response;

final class TripApiController extends Controller
{
    use RelationTrait;

    protected string $relationClass = GetTripByIdAction::class;

    public function index(IndexTripsRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var LengthAwarePaginator $trips */
        $trips = GetAllTripsAction::run();

        return fractal(
            $trips,
            new TripTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Trip::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(TripStoreApiRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var Trip $trip */
        $trip = StoreTripAction::run(TripData::fromRequest($request, 'data.attributes.'));

        return fractal(
            $trip,
            new TripTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Trip::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_CREATED, [
                'Location' => route('api.trips.show', [
                    'trip' => $trip->id
                ])
            ]);
    }

    public function show(ShowTripRequest $request, int $trip): \Illuminate\Http\JsonResponse
    {
        return fractal(
            GetTripByIdAction::run($trip),
            new TripTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Trip::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(TripUpdateApiRequest $request, int $trip): \Illuminate\Http\JsonResponse
    {
        $tripData = TripData::fromRequest($request, 'data.attributes.');
        $tripData->id = $trip;

        return fractal(
            UpdateTripAction::run($tripData),
            new TripTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Trip::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteTripRequest $request, int $trip): \Illuminate\Http\Response
    {
        DeleteTripAction::run($trip);

        return response()->noContent();
    }
}
