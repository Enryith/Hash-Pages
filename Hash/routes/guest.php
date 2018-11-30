<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Similar to web routes. These special guest routes require only guests.
| Any authenticated person will be redirected away from these routes.
| Usually authenticated users won't be able to login since they are already
| logged in.
|
*/

Route::get('/register', "Auth@register");
Route::post('/register', 'Auth@store');
Route::get('/auth/login', 'Auth@login');
Route::post('/auth/login', 'Auth@auth');
Route::get('/auth/{provider}', 'Auth@provider')
	->where('provider', '(google)');
Route::get('/auth/{provider}/endpoint', 'Auth@endpoint')
	->where('provider', '(google)');
