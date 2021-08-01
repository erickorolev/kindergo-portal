<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Controllers\Admin;

use Domains\Children\Actions\GetChildrenDropdownListAction;
use Domains\Trips\Actions\DeleteTripAction;
use Domains\Trips\Actions\GetAllTripsAdminAction;
use Domains\Trips\Actions\GetTripByIdAction;
use Domains\Trips\Actions\StoreTripAction;
use Domains\Trips\Actions\UpdateTripAction;
use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Http\Requests\Admin\CreateTimetableRequest;
use Domains\Trips\Http\Requests\Admin\EditTripRequest;
use Domains\Trips\Http\Requests\Admin\IndexTripsRequest;
use Domains\Trips\Http\Requests\Admin\ShowTripRequest;
use Domains\Trips\Http\Requests\Admin\TripStoreRequest;
use Domains\Trips\Http\Requests\Admin\DeleteTripRequest;
use Domains\Trips\Http\Requests\Admin\TripUpdateRequest;
use Domains\Trips\Models\Trip;
use Domains\Users\Actions\GetUsersDropdownListAction;
use Illuminate\Support\Collection;
use Parents\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class TripController extends Controller
{
    public function index(IndexTripsRequest $request): \Illuminate\View\View|View|Application
    {
        $search = $request->get('search', '');

        if (!$search) {
            $search = '';
        }
        /** @var Collection $trips */
        $trips = GetAllTripsAdminAction::run($search);

        return view('app.trips.index', compact('trips', 'search'));
    }

    public function create(CreateTimetableRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var Collection $users */
        $users = GetUsersDropdownListAction::run();
        /** @var Collection $children */
        $children = GetChildrenDropdownListAction::run();

        return view('app.trips.create', compact(
            'users',
            'children'
        ));
    }

    public function store(
        TripStoreRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        /** @var Trip $trip */
        $trip = StoreTripAction::run(TripData::fromRequest($request));

        return redirect()
            ->route('admin.trips.edit', $trip->id)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(ShowTripRequest $request, int $trip): \Illuminate\View\View|View|Application
    {
        /** @var Trip $trip */
        $trip = GetTripByIdAction::run($trip);

        return view('app.trips.show', compact('trip'));
    }

    public function edit(EditTripRequest $request, int $trip): \Illuminate\View\View|View|Application
    {
        /** @var Collection $users */
        $users = GetUsersDropdownListAction::run();
        /** @var Collection $children */
        $children = GetChildrenDropdownListAction::run();
        /** @var Trip $tripModel */
        $tripModel = GetTripByIdAction::run($trip);
        $selected_children = $tripModel->children->pluck('id')->toArray();

        return view(
            'app.trips.edit',
            [
                'trip' => $tripModel,
                'users' => $users,
                'children' => $children,
                'selected_children' => $selected_children
            ]
        );
    }

    public function update(
        TripUpdateRequest $request,
        int $trip
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $tripData = TripData::fromRequest($request);
        $tripData->id = $trip;
        $tripModel = UpdateTripAction::run($tripData);

        return redirect()
            ->route('admin.trips.edit', $tripModel->id)
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeleteTripRequest $request,
        int $trip
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        DeleteTripAction::run($trip);

        return redirect()
            ->route('admin.trips.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
