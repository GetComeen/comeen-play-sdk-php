<?php

use \Illuminate\Support\Facades\Route;
use \App\Domain\Application\Http\Controllers\ApplicationController;


Route::resource('authorizations','Http\Controllers\AuthorizationController')
    ->only(['index', 'store', 'update', 'destroy']);
