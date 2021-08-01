<?php

/**
 * @routeNamespace("Domains\Payments\Http\Controllers\Admin")
 * @routePrefix("admin.")
 */

use Domains\Payments\Http\Controllers\Admin\PaymentController;

Route::resource('payments', PaymentController::class);
