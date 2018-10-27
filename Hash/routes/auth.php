<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Similar to web routes. These routes require the user to be authenticated
| in some manner to access them. These routes don't check for authorization,
| but provides a simple way to make sure that a user exists when these
| routes are requested.
|
*/

Route::get('/tag', "Tag@form");
Route::post('/tag', "Tag@store");
Route::get('/post', "Post@form");
Route::post('/post', "Post@store");
Route::get('/settings', 'User@form');
Route::post('/settings', 'User@update');
Route::get('/chat', 'Chat@form');
Route::get('/user', 'User@self');
Route::get('/auth/logout', 'Auth@logout');
