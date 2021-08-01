<?php

/**
 * @routeNamespace("Domains\Payments\Http\Controllers\Api")
 * @routePrefix("api.")
 */

Route::get('payments/{id}/{relation}', [
    \Domains\Payments\Http\Controllers\Api\PaymentApiController::class,
    'relations'
])->name('payments.relations');
Route::post('payments/{id}/{relation}/{parent}', [
    \Domains\Payments\Http\Controllers\Api\PaymentApiController::class,
    'relationCreate'
])->name('payments.relations.create');
Route::apiResource('payments', \Domains\Payments\Http\Controllers\Api\PaymentApiController::class);
