<?php

use \Illuminate\Support\Facades\Route;


Route::resource('builds','Http\Controllers\BuildsController')
    ->only(['index', 'show', 'store', 'destroy']);
