<?php


use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Modules\Company\Http\Controllers\V1\CompanyController;

Route::group(['prefix' => 'api', 'as' => 'api.', 'middleware' => ['auth:sanctum', SubstituteBindings::class]], function () {

    Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

        Route::resource('job-applications', CompanyController::class)->only([
            'index', 'show', 'store', 'update', 'destroy'
        ]);

    });

});
