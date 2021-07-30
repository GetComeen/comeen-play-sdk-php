<?php

use \Illuminate\Support\Facades\Route;
use \App\Domain\Application\Http\Controllers\ApplicationController;


Route::name('auth.')->group(function () {
  Route::get('/login', 'Http\Controllers\LoginController@edit')->name('login');
  Route::post('/login', 'Http\Controllers\LoginController@authenticate')->name('authenticate');
});

//Route::name('auth:api.')->group(function () {
//    Route::post('/api/authenticate', 'Http\Controllers\LoginController@authenticate')->name('authenticate');
//});
