<?php

use App\Http\Controllers\API\V1\CodeController;
use App\Http\Controllers\API\V1\WinnerCheckController;
use App\Http\Controllers\API\V1\WinnerContoller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('codes', CodeController::class)->name('codes.store');

    Route::get('winners', WinnerContoller::class)->name('winners.index');

    Route::get('check', WinnerCheckController::class)->name('winners.check');
});
