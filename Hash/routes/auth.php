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

Route::get('/post', "Post@form");
Route::post('/post', "Post@store");
Route::post('/post/{id}', "Post@discussion");
Route::post('/post/reply/{id}', "Post@comment");
Route::post('/post/root/{id}', "Post@commentRoot");
Route::get('/comment/{id}/delete', "Comment@form");
Route::post('/comment/{id}/delete', 'Comment@delete');
Route::get('/discussion/{id}/delete', "Discussion@form");
Route::post('/discussion/{id}/delete', 'Discussion@delete');
Route::get('/settings', 'User@form');
Route::post('/settings', 'User@update');
Route::get('/chat', 'Chat@index');
Route::post('/chat', 'Chat@store');
Route::get('/chat/{id}', 'Chat@view');
Route::get('/user', 'User@self');
Route::get('/auth/logout', 'Auth@logout');
