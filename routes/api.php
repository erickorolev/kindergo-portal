<?php

use Domains\Authentication\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/v1/login', [AuthController::class, 'login'])->name('api.login');

Route::prefix('/v1/force')->group(function(){
    Route::get('Client/{id}',
        \Domains\Users\Http\Controllers\Api\ForceUserReceiveController::class);
    Route::get('Attendant/{id}', function () {
        return null;
    });
    Route::get('Child/{id}',
        \Domains\Children\Http\Controllers\Api\ForceChildReceiveController::class);
    Route::get('payments/{id}',
        \Domains\Payments\Http\Controllers\Api\ForcePaymentReceiveController::class);
    Route::get('timetables/{id}', function () {
        return null;
    });
    Route::get('trips/{id}',
        \Domains\Trips\Http\Controllers\Api\ForceTripReceiveController::class);
});
