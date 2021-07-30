<?php

use \Illuminate\Support\Facades\Route;


Route::resource('applications','Http\Controllers\ApplicationController')
    ->only(['show', 'index', 'store', 'update', 'destroy']);

Route::prefix('applications')->name('applications.')->group(function () {
    return Route::get('/{application}/sync', 'Http\Controllers\ApplicationController@sync')->name('sync');
});
