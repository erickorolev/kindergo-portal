<?php

/**
 * @routeNamespace("Domains\Trips\Http\Controllers\Api")
 * @routePrefix("api.")
 */

Route::get('trips/{id}/{relation}', [
    \Domains\Trips\Http\Controllers\Api\TripApiController::class,
    'relations'
])->name('trips.relations');
Route::post('trips/{id}/{relation}/{parent}', [
    \Domains\Trips\Http\Controllers\Api\TripApiController::class,
    'relationCreate'
])->name('trips.relations.create');
Route::apiResource('trips', \Domains\Trips\Http\Controllers\Api\TripApiController::class);
