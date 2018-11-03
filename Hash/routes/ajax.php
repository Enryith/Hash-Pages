<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AJAX Routes
|--------------------------------------------------------------------------
|
| Here are some routes that will be used when your clients make ajax
| requests to the server.
|
*/

Route::get('/test', "Ajax@test");
Route::post('/tags', "Ajax@tags");
Route::post('/vote', "Ajax@vote")->middleware("auth");
