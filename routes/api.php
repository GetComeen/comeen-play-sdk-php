<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

        Route::get('/', function (Request $request) {
            return DB::table('settings')->pluck('value', 'key');
        });

        Route::get('/applications/{app}/modules/{module}', "ModuleController@show");
        Route::get('/applications/{app}/modules', "ModuleController@index");

        Route::get('/applications', "ApplicationController@index")->name('applications.index');
        Route::get('/applications/{app}', "ApplicationController@show")->name('applications.show');
        Route::get('/applications/{app}/builds', "ApplicationController@getBuilds")->name('applications.builds');
        Route::get('/applications/{app}/builds/{identifier}', "ApplicationController@getBuild")->name('applications.build');

        Route::get('/bundles', "BundleController@index");
        Route::get('/bundles/{bundle}', "BundleController@show");

        Route::get('/auth-providers/{provider}', "AuthProviderController@initiate")->name('initiate');
        Route::get('/auth-providers/{provider}/test', "AuthProviderController@test")->name('test');
        Route::get('/auth-providers/{provider}/me', "AuthProviderController@userInfo")->name('userInfo');
        Route::post('/auth-providers/{provider}', "AuthProviderController@connect")->name('validate');

    });
