<?php

/**
 * @routeNamespace("Domains\Authorization\Http\Controllers\Admin")
 * @routePrefix("admin.")
 */

use Domains\Authorization\Http\Controllers\Admin\PermissionController;
use Domains\Authorization\Http\Controllers\Admin\RoleController;

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
