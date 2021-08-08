<?php

declare(strict_types=1);

namespace Domains\Children\Http\Controllers\Admin;

use Domains\Children\Actions\DeleteChildAction;
use Domains\Children\Actions\GetAllChildrenAdminAction;
use Domains\Children\Actions\GetChildByIdAction;
use Domains\Children\Actions\StoreChildAction;
use Domains\Children\Actions\UpdateChildAction;
use Domains\Children\DataTransferObjects\ChildData;
use Domains\Children\Http\Requests\Admin\ChildUpdateRequest;
use Domains\Children\Http\Requests\Admin\CreateChildRequest;
use Domains\Children\Http\Requests\Admin\DeleteChildRequest;
use Domains\Children\Http\Requests\Admin\IndexChildRequest;
use Domains\Children\Http\Requests\Admin\ChildStoreRequest;
use Domains\Children\Http\Requests\Admin\ShowChildRequest;
use Domains\Children\Http\Requests\Admin\EditChildRequest;
use Domains\Children\Models\Child;
use Domains\Users\Actions\GetAllUsersAction;
use Domains\Users\Actions\GetUsersDropdownListAction;
use Domains\Users\Actions\UpdateUserAction;
use Domains\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class ChildController extends Controller
{
    public function index(IndexChildRequest $request): \Illuminate\View\View|View|Application
    {
        $search = $request->get('search', '');
        /** @var LengthAwarePaginator $children */
        $children = GetAllChildrenAdminAction::run($search);

        return view('app.children.index', compact('children', 'search'));
    }

    public function create(CreateChildRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var User[] $users */
        $users = GetUsersDropdownListAction::run();

        return view('app.children.create', [
            'users' => $users,
            'selected_users' => []
        ]);
    }

    public function store(
        ChildStoreRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $childData = ChildData::fromRequest($request);
        /** @var Child $child */
        $child = StoreChildAction::run($childData);

        return redirect()
            ->route('admin.children.edit', [
                'child' => $child->id
            ])
            ->withSuccess(__('crud.common.created'));
    }

    public function show(ShowChildRequest $request, int $child): \Illuminate\View\View|View|Application
    {
        return view('app.children.show', [
            'child' => GetChildByIdAction::run($child)
        ]);
    }

    public function edit(EditChildRequest $request, int $child): \Illuminate\View\View|View|Application
    {
        /** @var User[] $users */
        $users = GetUsersDropdownListAction::run();
        /** @var Child $childModel */
        $childModel = GetChildByIdAction::run($child);

        return view('app.children.edit', [
            'child' => $childModel,
            'users' => $users,
            'selected_users' => $childModel->users->pluck('id')->toArray()
        ]);
    }

    public function update(
        ChildUpdateRequest $request,
        int $child
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $childData = ChildData::fromRequest($request);
        $childData->id = $child;
        /** @var Child $childModel */
        $childModel = UpdateChildAction::run($childData);

        return redirect()
            ->route('admin.children.edit', ['child' => $childModel->id])
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeleteChildRequest $request,
        int $child
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        DeleteChildAction::run($child);

        return redirect()
            ->route('admin.children.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
