<?php

declare(strict_types=1);

namespace Domains\Users\Http\Controllers\Admin;

use Domains\Authorization\Actions\GetAllRolesAction;
use Domains\Authorization\Models\Role;
use Domains\Users\Actions\Admin\IndexUserAction;
use Domains\Users\Actions\DeleteUserAction;
use Domains\Users\Actions\GetAllUsersAction;
use Domains\Users\Actions\GetUserByIdAction;
use Domains\Users\Actions\StoreUserAction;
use Domains\Users\Actions\UpdateUserAction;
use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Http\Requests\Admin\CreateUserRequest;
use Domains\Users\Http\Requests\Admin\DeleteUserRequest;
use Domains\Users\Http\Requests\Admin\EditUserRequest;
use Domains\Users\Http\Requests\Admin\IndexUserRequest;
use Domains\Users\Http\Requests\Admin\UserStoreRequest;
use Domains\Users\Http\Requests\Admin\ShowUserRequest;
use Domains\Users\Http\Requests\Admin\UserUpdateRequest;
use Domains\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class UserController extends Controller
{
    public function index(IndexUserRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var ?string $search */
        $search = $request->get('search', '');
        if (!$search) {
            $search = '';
        }
        /** @var LengthAwarePaginator $users */
        $users = IndexUserAction::run($search);

        return view('app.users.index', compact('users', 'search'));
    }

    public function create(CreateUserRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var Role[] $roles */
        $roles = GetAllRolesAction::run();

        return view('app.users.create', compact('roles'));
    }

    public function store(
        UserStoreRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        /** @var User $user */
        $user = StoreUserAction::run(UserData::fromRequest($request));

        return redirect()
            ->route('admin.users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(ShowUserRequest $request, int $user): \Illuminate\View\View|View|Application
    {

        return view('app.users.show', [
            'user' => GetUserByIdAction::run($user)
        ]);
    }

    public function edit(EditUserRequest $request, int $user): \Illuminate\View\View|View|Application
    {
        /** @var User $userModel */
        $userModel = GetUserByIdAction::run($user);
        /** @var Role[] $roles */
        $roles = GetAllRolesAction::run();

        return view('app.users.edit', [
            'user' => $userModel,
            'roles' => $roles
        ]);
    }

    public function update(
        UserUpdateRequest $request,
        int $user
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $userData = UserData::fromRequest($request);
        $userData->id = $user;
        $userModel = UpdateUserAction::run($userData);

        return redirect()
            ->route('admin.users.edit', $userModel)
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeleteUserRequest $request,
        int $user
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        DeleteUserAction::run($user);

        return redirect()
            ->route('admin.users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
