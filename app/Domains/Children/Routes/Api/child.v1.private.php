<?php

/**
 * @routeNamespace("Domains\Children\Http\Controllers\Api")
 * @routePrefix("api.")
 */

Route::get('children/{id}/{relation}', [
    \Domains\Children\Http\Controllers\Api\ChildApiController::class,
    'relations'
])->name('children.relations');
Route::post('children/{id}/{relation}/{parent}', [
    \Domains\Children\Http\Controllers\Api\ChildApiController::class,
    'relationCreate'
])->name('children.relations.create');
Route::apiResource('children', \Domains\Children\Http\Controllers\Api\ChildApiController::class);
