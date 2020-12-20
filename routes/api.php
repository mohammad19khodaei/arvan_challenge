<?php

use App\Http\Controllers\API\V1\CodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('codes', CodeController::class)->name('codes.store');
});
