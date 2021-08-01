<?php

declare(strict_types=1);

namespace Domains\Authorization\Http\Controllers\Admin;

use Domains\Authorization\Actions\DeletePermissionAction;
use Domains\Authorization\Actions\GetAllPermissionsAdminAction;
use Domains\Authorization\Actions\GetAllRolesAction;
use Domains\Authorization\Actions\GetPermissionByIdAction;
use Domains\Authorization\Actions\StorePermissionAction;
use Domains\Authorization\Actions\UpdatePermissionAction;
use Domains\Authorization\DataTransferObjects\PermissionData;
use Domains\Authorization\Http\Requests\Admin\IndexPermissionsRequest;
use Domains\Authorization\Http\Requests\Admin\CreatePermissionRequest;
use Domains\Authorization\Http\Requests\Admin\DeletePermissionRequest;
use Domains\Authorization\Http\Requests\Admin\EditPermissionRequest;
use Domains\Authorization\Http\Requests\Admin\ShowPermissionRequest;
use Domains\Authorization\Http\Requests\Admin\StorePermissionRequest;
use Domains\Authorization\Http\Requests\Admin\UpdatePermissionRequest;
use Domains\Authorization\Models\Permission;
use Domains\Authorization\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class PermissionController extends Controller
{

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function index(IndexPermissionsRequest $request): self|View|Application
    {
        /** @var ?string $search */
        $search = $request->get('search', '');
        if (!$search) {
            $search = '';
        }
        /** @var LengthAwarePaginator $permissions */
        $permissions = GetAllPermissionsAdminAction::run($search);

        return view('app.permissions.index')
            ->with('permissions', $permissions)
            ->with('search', $search);
    }

    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function create(CreatePermissionRequest $request): self|View|Application
    {
        $roles = GetAllRolesAction::run();
        return view('app.permissions.create')->with('roles', $roles);
    }

    public function store(
        StorePermissionRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $permission = StorePermissionAction::run(PermissionData::fromRequest($request));

        return redirect()
            ->route('admin.permissions.edit', $permission->id)
            ->withSuccess(__('crud.common.created'));
    }


    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function show(ShowPermissionRequest $request, int $permission): self|View|Application
    {
        /** @var Permission $permissionModel */
        $permissionModel = GetPermissionByIdAction::run($permission);

        return view('app.permissions.show')->with('permission', $permissionModel);
    }


    /**
     * @return \Illuminate\View\View
     * @psalm-suppress MismatchingDocblockReturnType
     */
    public function edit(EditPermissionRequest $request, int $permission): self|View|Application
    {
        /** @var Permission $permissionModel */
        $permissionModel = GetPermissionByIdAction::run($permission);
        /** @var Role[] $roles */
        $roles = GetAllRolesAction::run();

        return view('app.permissions.edit')
            ->with('permission', $permissionModel)
            ->with('roles', $roles);
    }

    public function update(
        UpdatePermissionRequest $request,
        int $permission
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $permissionData = PermissionData::fromRequest($request);
        $permissionData->id = $permission;
        /** @var Permission $permissionModel */
        $permissionModel = UpdatePermissionAction::run($permissionData);

        return redirect()
            ->route('admin.permissions.edit', $permissionModel)
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeletePermissionRequest $request,
        int $permission
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        DeletePermissionAction::run($permission);

        return redirect()
            ->route('admin.permissions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
