<?php

/**
 * @routeNamespace("Domains\Users\Http\Controllers\Api")
 * @routePrefix("api.")
 */

use Domains\Users\Http\Controllers\Api\UserApiController;

Route::get('users/{id}/{relation}', [
    UserApiController::class,
    'relations'
])->name('users.relations');
Route::post('users/{id}/{relation}/{parent}', [
    \Domains\Users\Http\Controllers\Api\UserApiController::class,
    'relationCreate'
])->name('children.relations.create');
\Illuminate\Support\Facades\Route::get('users/me', [
    UserApiController::class,
    'me'
])->name('users.me');
Route::post('users/password', [
    UserApiController::class,
    'password'
])->name('users.password');
Route::apiResource('users', UserApiController::class);
