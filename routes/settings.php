<?php

use \Illuminate\Support\Facades\Route;


Route::name('settings.')->group(function () {
    Route::get('settings', 'Http\Controllers\SettingsController@show')->name('show');
    Route::post('settings', 'Http\Controllers\SettingsController@update')->name('update');
});
