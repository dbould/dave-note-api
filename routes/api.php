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

Route::get('/notes', 'NoteController@getAllNotes')->middleware(\App\Http\Middleware\Cors::class);
Route::get('/note/{id}', 'NoteController@getNote')->middleware(\App\Http\Middleware\Cors::class);
Route::post('/note/create', 'NoteController@createNote')->middleware(\App\Http\Middleware\Cors::class);
Route::post('/note/update/{id}', 'NoteController@updateNote')->middleware(\App\Http\Middleware\Cors::class);
Route::post('/note/delete/{id}', 'NoteController@deleteNote')->middleware(\App\Http\Middleware\Cors::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
