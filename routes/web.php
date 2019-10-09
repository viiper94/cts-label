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
Route::get('/', 'ReleasesController@index')->name('home');
Route::get('/search', 'ReleasesController@index')->name('search');
Route::get('/releases/{id}', 'ReleasesController@show')->name('release');
Route::get('/artists', 'ArtistsController@index')->name('artists');
Route::get('/reviews', 'ReviewsController@index')->name('reviews');
Route::get('/about.html', 'AppController@contact')->name('about');
Route::get('/studio.html', 'AppController@studio')->name('studio');
Route::get('/ctschool.html', 'AppController@ctschool')->name('ctschool');
