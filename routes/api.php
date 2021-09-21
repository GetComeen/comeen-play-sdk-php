<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::githubWebhooks('webhooks/github');

Route::namespace('App\Domain\API\Controllers\\')
//    ->middleware(['api'])
    ->middleware(['auth:api'])
    ->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->user();
        });

        Route::get('/applications/{app}/modules/{module}', "ModuleController@show");
//        Route::post('/applications/{app}/modules/{module}', "ModuleController@update");

        Route::get('/applications', "ApplicationController@index");
        Route::get('/applications/{app}', "ApplicationController@show");
        Route::get('/applications/{app}/build', "ApplicationController@getBuild");

        Route::get('/bundles', "BundleController@index");
        Route::get('/bundles/{bundle}', "BundleController@show");

        Route::get('/auth-providers/{provider}', "AuthProviderController@initiate")->name('initiate');
        Route::post('/auth-providers/{provider}', "AuthProviderController@connect")->name('validate');

    });
