<?php

use Illuminate\Support\Facades\Route;
use Modules\JatAuth\Http\Controllers\JatAuthController;

Route::group(['prefix' => 'api'], function () {

    Route::post('login', [JatAuthController::class, 'login'])->name('login');

    Route::post('logout', [JatAuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

});

