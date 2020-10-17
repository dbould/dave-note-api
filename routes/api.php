<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/notes', 'NoteController@getAllNotes')->middleware('cors');
Route::get('/note/0', 'NoteController@getLatestUpdatedNote')->middleware('cors');
Route::get('/note/{id}', 'NoteController@getNote')->middleware('cors');
Route::post('/note/create', 'NoteController@createNote')->middleware('cors');
Route::post('/note/update/{id}', 'NoteController@updateNote')->middleware('cors');
Route::post('/note/delete/{id}', 'NoteController@deleteNote')->middleware('cors');

Route::get('/user', 'UserController')->middleware('auth:api');
