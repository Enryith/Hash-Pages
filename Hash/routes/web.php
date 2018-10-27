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

//Public
Route::get('/', 'Auth@welcome');
Route::get('/all', "Post@index");
Route::get('/post/{id}', "Post@view");
Route::get('/user/{username}', 'User@view');
Route::get('/send/{message}', 'Socket@send');
Route::get('/listen', 'Socket@listen');

//Guest
Route::get('/register', "Auth@register")->middleware("guest");
Route::post('/register', 'Auth@store')->middleware("guest");
Route::get('/auth/login', 'Auth@login')->middleware("guest");
Route::post('/auth/login', 'Auth@auth')->middleware("guest");

//Private
Route::get('/tag', "Tag@form")->middleware("auth");
Route::post('/tag', "Tag@store")->middleware("auth");
Route::get('/post', "Post@form")->middleware("auth");
Route::post('/post', "Post@store")->middleware("auth");
Route::get('/auth/logout', 'Auth@logout')->middleware("auth");
Route::get('/settings', 'User@form')->middleware("auth");
Route::post('/settings', 'User@update')->middleware("auth");
Route::get('/chat', 'Chat@form')->middleware("auth");
Route::get('/user', 'User@self')->middleware("auth");
