<?php

/**
 * @routeNamespace("Domains\Trips\Http\Controllers\Admin")
 * @routePrefix("admin.")
 */

Route::resource('trips', \Domains\Trips\Http\Controllers\Admin\TripController::class);
