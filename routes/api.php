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
Route::get('/notes', 'NoteController@getAllNotes')->middleware(\Fruitcake\Cors\HandleCors::class);
Route::get('/note/0', 'NoteController@getLatestUpdatedNote')->middleware(\Fruitcake\Cors\HandleCors::class);
Route::get('/note/{id}', 'NoteController@getNote')->middleware(\Fruitcake\Cors\HandleCors::class);
Route::post('/note/create', 'NoteController@createNote')->middleware(\Fruitcake\Cors\HandleCors::class);
Route::post('/note/update/{id}', 'NoteController@updateNote')->middleware(\Fruitcake\Cors\HandleCors::class);
Route::post('/note/delete/{id}', 'NoteController@deleteNote')->middleware(\Fruitcake\Cors\HandleCors::class);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
