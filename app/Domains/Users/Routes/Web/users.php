<?php

/**
 * @routeNamespace("Domains\Users\Http\Controllers\Admin")
 * @routePrefix("admin.")
 */

use Domains\Users\Http\Controllers\Admin\UserController;

Route::resource('users', UserController::class);
