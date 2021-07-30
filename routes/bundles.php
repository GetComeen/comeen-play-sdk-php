<?php

use \Illuminate\Support\Facades\Route;


Route::resource('bundles','Http\Controllers\BundleController')
    ->only(['index', 'show', 'store', 'update', 'destroy']);
