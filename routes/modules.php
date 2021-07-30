<?php

use \Illuminate\Support\Facades\Route;

Route::resource('modules','Http\Controllers\ModuleController')
    ->only(['show', 'store', 'update', 'destroy']);
