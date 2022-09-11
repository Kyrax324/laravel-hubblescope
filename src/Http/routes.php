<?php

use Illuminate\Support\Facades\Route;
use Microscope\Http\Controllers\MainController;

Route::prefix('microscope-api')->middleware([])->group(function ()
{
	Route::post('/search', [MainController::class, 'search']);
	Route::post('/dump-query', [MainController::class, 'dumpQuery']);
});

// Route::get('/microscope', [MainController::class, 'index']);

Route::get('/microscope/{view?}', [MainController::class, 'index'])->where('view', '(.*)')->name('microscope');