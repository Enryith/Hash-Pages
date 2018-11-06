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
Route::get('/tags', "Ajax@tags");
Route::post('/tags', "Ajax@tags");
Route::get('/users',"Ajax@users");
Route::post('/users',"Ajax@users");
Route::post('/vote', "Ajax@vote")->middleware("auth");
Route::post('/message', "Ajax@message")->middleware("auth");
