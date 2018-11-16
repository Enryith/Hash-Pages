<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth@welcome');
Route::get('/all', "Post@index");
Route::get('/post/{id}', "Post@view");
Route::get('/user/{username}', 'User@view');
Route::get('/feed', 'Feed@feed');
Route::get('/post/{id}', 'Post@removeComment');