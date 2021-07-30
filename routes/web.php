<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Home\Http\Controllers\HomeController;

Route::get("/", [HomeController::class, "index"])->name('home');

Route::namespace('App\Domain\Auth')->group(__DIR__ . '/auth.php');

Route::middleware('auth')->group(function() {
    Route::namespace('App\Domain\Application')->group(__DIR__ . '/applications.php');
    Route::namespace('App\Domain\User')->group(__DIR__ . '/users.php');
    Route::namespace('App\Domain\Bundle')->group(__DIR__ . '/bundles.php');
    Route::namespace('App\Domain\Module')->group(__DIR__ . '/modules.php');
    Route::namespace('App\Domain\Builds')->group(__DIR__ . '/builds.php');
    Route::namespace('App\Domain\Settings')->group(__DIR__ . '/settings.php');
    Route::namespace('App\Domain\Authorization')->group(__DIR__ . '/authorizations.php');
});
