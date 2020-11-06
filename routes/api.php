<?php

use Fruitcake\Cors\HandleCors;
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
Route::get('/notes', 'NoteController@getAllNotes')->middleware(HandleCors::class);
Route::get('/note/0', 'NoteController@getLatestUpdatedNote')->middleware(HandleCors::class);
Route::get('/note/{id}', 'NoteController@getNote')->middleware(HandleCors::class);
Route::post('/note/create', 'NoteController@createNote')->middleware(HandleCors::class);
Route::post('/note/update/{id}', 'NoteController@updateNote')->middleware(HandleCors::class);
Route::post('/note/delete/{id}', 'NoteController@deleteNote')->middleware(HandleCors::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
