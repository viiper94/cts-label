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

use App\Http\Controllers\Admin\AdminArtistsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSchoolCvController;
use App\Http\Controllers\Admin\AdminEmailingChannelsController;
use App\Http\Controllers\Admin\AdminEmailingContactsController;
use App\Http\Controllers\Admin\AdminEmailingQueueController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminReleasesController;
use App\Http\Controllers\Admin\AdminReviewsController;
use App\Http\Controllers\Admin\AdminSchoolCoursesController;
use App\Http\Controllers\Admin\AdminSchoolTeachersController;
use App\Http\Controllers\Admin\AdminStudioController;
use App\Http\Controllers\Admin\AdminUsersController;

Route::group(['middleware' => 'i18n'], function(){

    Auth::routes();
    Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook')->name('auth.facebook');
    Route::get('auth/google', 'Auth\LoginController@redirectToGoogle')->name('auth.google');
    Route::get('auth/google/handle', 'Auth\LoginController@handleGoogleCallback');

    Route::get('/', 'ReleasesController@index')->name('home');
    Route::get('/search', 'ReleasesController@index')->name('search');
    Route::get('/releases/{id}', 'ReleasesController@show')->name('release');
    Route::get('/artists', 'ArtistsController@index')->name('artists');
    Route::get('/reviews', 'ReviewsController@index')->name('reviews');
    Route::get('/about.html', 'AppController@about')->name('about');
    Route::get('/studio.html', 'AppController@studio')->name('studio');
    Route::post('/studio.html', 'AppController@sendCallback');
    Route::get('/ctschool.html', 'AppController@ctschool')->name('school');
    Route::post('/ctschool.html', 'AppController@sendCallback');
    Route::any('/anketa', 'CvController@index')->name('school.cv');
    Route::any('/feedback/{slug}', 'FeedbackController@show')->name('feedback');
    Route::get('/feedback/{slug}/end', 'FeedbackController@end')->name('feedback.end');
    Route::any('/unsubscribe/{hash}', 'Controller@unsubscribe')->name('unsubscribe');

    Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => '/cts-admin'], function(){

        Route::get('/', [AdminController::class, 'index'])->name('admin');

        Route::resource('/users', AdminUsersController::class)->only(['index', 'destroy']);

        Route::post('/artists/resort', [AdminArtistsController::class, 'resort'])->name('artists.resort');
        Route::get('/artists/sort/{artist}/{dir}', [AdminArtistsController::class, 'sort'])->name('artists.sort');
        Route::resource('/artists', AdminArtistsController::class)->except(['show']);

        Route::post('/releases/related', [AdminReleasesController::class, 'searchRelated']);
        Route::post('/releases/translate', [AdminReleasesController::class, 'translate']);
        Route::post('/releases/resort', [AdminReleasesController::class, 'resort'])->name('releases.resort');
        Route::get('/releases/sort/{release}/{dir}', [AdminReleasesController::class, 'sort'])->name('releases.sort');
        Route::resource('/releases', AdminReleasesController::class)->except(['show']);

        Route::post('/reviews/template', [AdminReviewsController::class, 'getTemplate'])->name('reviews.template');
        Route::post('/reviews/search', [AdminReviewsController::class, 'search'])->name('reviews.search');
        Route::post('/reviews/resort', [AdminReviewsController::class, 'resort'])->name('reviews.resort');
        Route::get('/reviews/sort/{review}/{dir}', [AdminReviewsController::class, 'sort'])->name('reviews.sort');
        Route::resource('/reviews', AdminReviewsController::class)->except(['show']);

        Route::post('/studio/resort', [AdminStudioController::class, 'resort'])->name('studio.resort');
        Route::resource('/studio', AdminStudioController::class)->except(['show', 'edit', 'create']);

        Route::post('/feedback/template', [AdminFeedbackController::class, 'getTemplate'])->name('feedback.template');
        Route::get('/feedback/create/{release?}', [AdminFeedbackController::class, 'create'])->name('feedback.create');
        Route::put('/feedback/store/{release?}', [AdminFeedbackController::class, 'store'])->name('feedback.store');
        Route::delete('/feedback/delete/{result}', [AdminFeedbackController::class, 'deleteResult'])->name('feedback.deleteResult');
        Route::resource('/feedback', AdminFeedbackController::class)->except(['show', 'create', 'store']);

        Route::name('school.')->prefix('school')->group(function(){

            Route::post('/courses/resort', [AdminSchoolCoursesController::class, 'resort'])->name('courses.resort');
            Route::resource('/courses', AdminSchoolCoursesController::class)->except(['show', 'edit', 'create']);

            Route::post('/teachers/resort', [AdminSchoolTeachersController::class, 'resort'])->name('teachers.resort');;
            Route::resource('/teachers', AdminSchoolTeachersController::class)->except(['show', 'edit', 'create']);

            Route::get('/cv/document/{cv}', [AdminSchoolCvController::class, 'document'])->name('cv.document');
            Route::resource('/cv', AdminSchoolCvController::class)->only(['index', 'show', 'destroy']);

        });

        Route::name('emailing.')->prefix('emailing')->group(function(){

            Route::post('/channels/start', [AdminEmailingChannelsController::class, 'start'])->name('channels.start');
            Route::post('/channels/stop', [AdminEmailingChannelsController::class, 'stop'])->name('channels.stop');
            Route::resource('/channels', AdminEmailingChannelsController::class)->except(['show']);

            Route::resource('/contacts', AdminEmailingContactsController::class)->except(['show']);

            Route::get('/queue', [AdminEmailingQueueController::class, 'index'])->name('queue.index');
            Route::delete('/clear', [AdminEmailingQueueController::class, 'clear'])->name('queue.clear');

        });

    });

});
