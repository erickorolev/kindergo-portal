<?php

/**
 * @routeNamespace("Domains\Children\Http\Controllers\Admin")
 * @routePrefix("admin.")
 */

use Domains\Children\Http\Controllers\Admin\ChildController;

Route::resource('children', ChildController::class);
