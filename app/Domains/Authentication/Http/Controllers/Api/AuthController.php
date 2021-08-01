<?php

declare(strict_types=1);

namespace Domains\Authentication\Http\Controllers\Api;

use Domains\Authentication\Http\Requests\LoginRequest;
use Domains\Users\Actions\GetUserByEmailAction;
use Parents\Controllers\Controller;
use Illuminate\Validation\ValidationException;

final class AuthController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $user = GetUserByEmailAction::run($request->input('email'));

        $token = $user?->createToken('auth-token');

        return response()->json([
            'token' => $token?->plainTextToken,
        ]);
    }
}
