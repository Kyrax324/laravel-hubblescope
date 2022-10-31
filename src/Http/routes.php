<?php

use Illuminate\Support\Facades\Route;
use Hubblescope\Http\Controllers\MainController;

Route::prefix('hubblescope-api')->middleware([])->group(function ()
{
	Route::post('/search', [MainController::class, 'search']);
	Route::post('/dump-query', [MainController::class, 'dumpQuery']);
});

Route::get('/{view?}', [MainController::class, 'index'])->where('view', '(.*)')->name('hubblescope');