<?php

use Illuminate\Support\Facades\Route;
use Modules\JatAuth\Http\Controllers\JatAuthController;

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {

    Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

        Route::post('login', [JatAuthController::class, 'login'])->name('login');

    });

    Route::post('logout', [JatAuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

});

