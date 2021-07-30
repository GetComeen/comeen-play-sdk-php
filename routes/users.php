<?php

use \Illuminate\Support\Facades\Route;


Route::resource('users','Http\Controllers\UserController')
    ->only(['index', 'store', 'update', 'destroy']);
