<?php

declare(strict_types=1);

namespace Domains\Users\Http\Controllers\Api;

use Domains\Users\Actions\DeleteUserAction;
use Domains\Users\Actions\GetAllUsersAction;
use Domains\Users\Actions\GetUserByIdAction;
use Domains\Users\Actions\StoreUserAction;
use Domains\Users\Actions\UpdateUserAction;
use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Http\Requests\Admin\DeleteUserRequest;
use Domains\Users\Http\Requests\Admin\IndexUserRequest;
use Domains\Users\Http\Requests\Admin\ShowUserRequest;
use Domains\Users\Http\Requests\Api\UserStoreApiRequest;
use Domains\Users\Http\Requests\Api\UserUpdateApiRequest;
use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Domains\Users\ValueObjects\PasswordValueObject;
use Illuminate\Support\Facades\Auth;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;
use Parents\Traits\RelationTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Domains\Users\Actions\Fortify\UpdateUserPassword;

final class UserApiController extends Controller
{
    use RelationTrait;

    /**
     * @psalm-param class-string $relationClass
     */
    protected string $relationClass = GetUserByIdAction::class;
    /**
     * @param  Request  $request
     * @param  UpdateUserPassword  $action
     * @return \Illuminate\Http\JsonResponse
     * @psalm-suppress PossiblyNullArgument
     */
    public function password(Request $request, UpdateUserPassword $action): \Illuminate\Http\JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $action->update($user, $request->all());
        return fractal(
            $user,
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        return fractal(
            $user,
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function index(IndexUserRequest $request, GetAllUsersAction $action): \Illuminate\Http\JsonResponse
    {
        return fractal(
            $action(),
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(UserStoreApiRequest $request): \Illuminate\Http\JsonResponse
    {
        $userData = UserData::fromRequest($request, 'data.attributes.');
        if (!$userData->password) {
            $userData->password = PasswordValueObject::generateRandom();
        }
        $user = StoreUserAction::run($userData);
        return fractal(
            $user,
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_CREATED, [
                'Location' => route('api.users.show', [
                    'user' => $user->id
                ])
            ]);
    }

    public function show(ShowUserRequest $request, int $user): \Illuminate\Http\JsonResponse
    {
        $userModel = GetUserByIdAction::run($user);
        return fractal(
            $userModel,
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(UserUpdateApiRequest $request, int $user): \Illuminate\Http\JsonResponse
    {
        $userData = UserData::fromRequest($request, 'data.attributes.');
        $userData->id = $user;
        $userModel = UpdateUserAction::run($userData);

        return fractal(
            $userModel,
            new UserTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(User::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteUserRequest $request, int $user): \Illuminate\Http\Response
    {
        DeleteUserAction::run($user);

        return response()->noContent();
    }
}
