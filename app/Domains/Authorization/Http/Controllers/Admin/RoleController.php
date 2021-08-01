<?php

declare(strict_types=1);

namespace Domains\Authorization\Http\Controllers\Admin;

use Domains\Authorization\Actions\DeleteRoleByIdAction;
use Domains\Authorization\Actions\GetAllPermissionsAction;
use Domains\Authorization\Actions\GetAllRolesAdminAction;
use Domains\Authorization\Actions\GetRoleByIdAction;
use Domains\Authorization\Actions\StoreRoleAction;
use Domains\Authorization\Actions\UpdateRoleAction;
use Domains\Authorization\DataTransferObjects\RoleData;
use Domains\Authorization\Http\Requests\Admin\DeleteRoleRequest;
use Domains\Authorization\Http\Requests\Admin\IndexRoleRequest;
use Domains\Authorization\Http\Requests\Admin\CreateRoleRequest;
use Domains\Authorization\Http\Requests\Admin\ShowRoleRequest;
use Domains\Authorization\Http\Requests\Admin\StoreRoleRequest;
use Domains\Authorization\Http\Requests\Admin\EditRoleRequest;
use Domains\Authorization\Http\Requests\Admin\UpdateRoleRequest;
use Domains\Authorization\Models\Permission;
use Domains\Authorization\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class RoleController extends Controller
{

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function index(IndexRoleRequest $request): self|View|Application
    {
        $search = $request->get('search', '');
        if (!$search) {
            $search = '';
        }
        /** @var LengthAwarePaginator $roles */
        $roles = GetAllRolesAdminAction::run($search);

        return view('app.roles.index')
            ->with('roles', $roles)
            ->with('search', $search);
    }

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function create(CreateRoleRequest $request): self|View|Application
    {
        /** @var Permission[] $permissions */
        $permissions = GetAllPermissionsAction::run();

        return view('app.roles.create')->with('permissions', $permissions);
    }

    public function store(
        StoreRoleRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        /** @var Role $role */
        $role = StoreRoleAction::run(RoleData::fromRequest($request));

        return redirect()
            ->route('admin.roles.edit', $role->id)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function show(ShowRoleRequest $request, int $role): self|View|Application
    {
        $roleModel = GetRoleByIdAction::run($role);

        return view('app.roles.show')->with('role', $roleModel);
    }

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function edit(EditRoleRequest $request, int $role): self|View|Application
    {
        /** @var Permission[] $permissions */
        $permissions = GetAllPermissionsAction::run();
        /** @var Role $roleModel */
        $roleModel = GetRoleByIdAction::run($role);

        return view('app.roles.edit')
            ->with('role', $roleModel)
            ->with('permissions', $permissions);
    }

    public function update(
        UpdateRoleRequest $request,
        int $role
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $roleData = RoleData::fromRequest($request);
        $roleData->id = $role;

        $roleModel = UpdateRoleAction::run($roleData);

        return redirect()
            ->route('admin.roles.edit', $roleModel->id)
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeleteRoleRequest $request,
        int $role
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        DeleteRoleByIdAction::run($role);

        return redirect()
            ->route('admin.roles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
