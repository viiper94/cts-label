<?php

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

Auth::routes();
Route::get('/', 'ReleasesController@index');
Route::get('/releases/{id}', 'ReleasesController@show');
Route::get('/artists', 'ArtistsController@index');
Route::get('/reviews', 'ReviewsController@index');
Route::get('/about.html', 'AppController@contact');
Route::get('/studio.html', 'AppController@studio');
Route::get('/ctschool.html', 'AppController@ctschool');
