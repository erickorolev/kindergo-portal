<?php

/**
 * @routeNamespace("Domains\TemporaryFile\Http\Controllers\Api\V1")
 * @routePrefix("api.")
 */

Route::post('upload', \Domains\TemporaryFile\Http\Controller\Api\V1\UploadController::class)
    ->name('fileUpload');
