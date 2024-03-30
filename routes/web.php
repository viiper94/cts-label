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

use App\Http\Controllers\Admin\AdminArtistsCvController;
use App\Http\Controllers\ArtistsContactInfoController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\ArtistsCvController;
use App\Http\Controllers\GuestlistController;
use App\Http\Controllers\Admin\AdminArtistsController;
use App\Http\Controllers\Admin\AdminSchoolCvController;
use App\Http\Controllers\Admin\AdminEmailingChannelsController;
use App\Http\Controllers\Admin\AdminEmailingContactsController;
use App\Http\Controllers\Admin\AdminEmailingQueueController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminFeedbackResultController;
use App\Http\Controllers\Admin\AdminReleasesController;
use App\Http\Controllers\Admin\AdminReviewsController;
use App\Http\Controllers\Admin\AdminSchoolCoursesController;
use App\Http\Controllers\Admin\AdminSchoolTeachersController;
use App\Http\Controllers\Admin\AdminStudioController;
use App\Http\Controllers\Admin\AdminTracksController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebinarContactController;

Route::group(['middleware' => 'i18n'], function(){

    Auth::routes();
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);

    Route::get('/', 'ReleasesController@index')->name('home');
    Route::get('/feed', 'ReleasesController@rss')->name('rss');
    Route::get('/search', 'ReleasesController@index')->name('search');

    Route::get('/releases/{id}', 'ReleasesController@show')->name('release');
    Route::get('/releases/track/{track}/{release?}', 'ReleasesController@track');

    Route::name('artists.public.')->group(function(){

        Route::get('/artists', [ArtistsController::class, 'index'])->name('artists');
        Route::post('/artistform/track', [ArtistsCvController::class, 'getTrackItem'])->name('info.track');
        Route::get('/artistform', [ArtistsCvController::class, 'create'])->name('info.create');
        Route::post('/artistform', [ArtistsCvController::class, 'store'])->name('info.store');
        Route::resource('/contact', ArtistsContactInfoController::class)->except(['index', 'show', 'destroy']);

    });

    Route::get('/reviews', 'ReviewsController@index')->name('reviews');

    Route::get('/about.html', 'AppController@about')->name('about');

    Route::get('/studio.html', 'AppController@studio')->name('studio');
    Route::post('/studio.html', 'AppController@sendCallback');

    Route::get('/ctschool.html', 'AppController@ctschool')->name('school');
    Route::post('/ctschool.html', 'AppController@sendCallback');
    Route::any('/anketa', 'CvController@index')->name('school.cv');

    Route::any('/feedback/{slug}', 'FeedbackController@show')->name('feedback');
    Route::get('/feedback/{slug}/end', 'FeedbackController@end')->name('feedback.end');
    Route::get('/feedback/{slug}/tracks', 'FeedbackController@getTracks');

    Route::any('/unsubscribe/{hash}', 'Controller@unsubscribe')->name('unsubscribe');

    Route::get('/ade2023/guestlist', [GuestlistController::class, 'index'])->name('guestlist');
    Route::post('/ade2023/guestlist', [GuestlistController::class, 'store'])->name('guestlist.add');

    Route::get('/event/marketing-and-management', [WebinarContactController::class, 'index'])->name('event');
    Route::post('/event/marketing-and-management', [WebinarContactController::class, 'store']);

    Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => '/cts-admin'], function(){

        Route::get('/', function(){
            return redirect()->route('releases.index');
        })->name('admin');

        Route::get('/event', [WebinarContactController::class, 'admin'])->name('event.index');
        Route::delete('/event/{contact}', [WebinarContactController::class, 'destroy'])->name('event.destroy');

        Route::get('/users', [AdminUsersController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [AdminUsersController::class, 'destroy'])->name('users.destroy');

        Route::post('/artists/resort', [AdminArtistsController::class, 'resort'])->name('artists.resort');
        Route::get('/artists/sort/{artist}/{dir}', [AdminArtistsController::class, 'sort'])->name('artists.sort');
        Route::resource('/artists', AdminArtistsController::class)->except(['show']);

        Route::get('/artists/cv', [AdminArtistsCvController::class, 'index'])->name('artists_cv.index');
        Route::get('/artists/cv/{cv}', [AdminArtistsCvController::class, 'show'])->name('artists_cv.show');
        Route::get('/artists/cv/{cv}/document', [AdminArtistsCvController::class, 'document'])->name('artists_cv.document');
        Route::delete('/artists/cv/{cv}/destroy', [AdminArtistsCvController::class, 'destroy'])->name('artists_cv.destroy');

        Route::post('/releases/labelCopy/{release}', [AdminReleasesController::class, 'labelCopy'])->name('releases.labelCopy');
        Route::post('/releases/getCat', [AdminReleasesController::class, 'generateReleaseNumber'])->name('releases.getCat');
        Route::post('/releases/add_track', [AdminReleasesController::class, 'addTrack'])->name('releases.add_track');
        Route::post('/releases/related', [AdminReleasesController::class, 'searchRelated']);
        Route::post('/releases/translate', [AdminReleasesController::class, 'translate']);
        Route::post('/releases/resort', [AdminReleasesController::class, 'resort'])->name('releases.resort');
        Route::get('/releases/sort/{release}/{dir}', [AdminReleasesController::class, 'sort'])->name('releases.sort');
        Route::resource('/releases', AdminReleasesController::class)->except(['show']);

        Route::post('/tracks/updateShowReviews/{track}', [AdminTracksController::class, 'updateShowReviews'])->name('tracks.updateShowReviews');
        Route::get('/tracks/export', [AdminTracksController::class, 'export'])->name('tracks.export');
        Route::post('/tracks/isrc/get', [AdminTracksController::class, 'generateISRCCode'])->name('tracks.isrc.get');
        Route::post('/tracks/isrc/check', [AdminTracksController::class, 'checkISRCCode'])->name('tracks.isrc.check');
        Route::post('/tracks/search', [AdminTracksController::class, 'search'])->name('tracks.search');
        Route::post('/tracks/updateTrack', [AdminTracksController::class, 'updateTrack'])->name('tracks.updateTrack');
        Route::resource('/tracks', AdminTracksController::class)->except(['show']);

        Route::post('/reviews/search', [AdminReviewsController::class, 'search'])->name('reviews.search');
        Route::post('/reviews/resort', [AdminReviewsController::class, 'resort'])->name('reviews.resort');
        Route::resource('/reviews', AdminReviewsController::class)->except(['index']);

        Route::post('/studio/resort', [AdminStudioController::class, 'resort'])->name('studio.resort');
        Route::resource('/studio', AdminStudioController::class)->except(['show']);

        Route::get('/feedback/result/add/{result}', [AdminFeedbackResultController::class, 'add'])->name('feedback.result.add');
        Route::post('/feedback/result/modify/{result}', [AdminFeedbackResultController::class, 'modify'])->name('feedback.result.modify');
        Route::delete('/feedback/result/destroy/{result}', [AdminFeedbackResultController::class, 'destroy'])->name('feedback.result.destroy');

        Route::post('/feedback/peaks', [AdminFeedbackController::class, 'peaks'])->name('feedback.peaks');
        Route::post('/feedback/template', [AdminFeedbackController::class, 'getTemplate'])->name('feedback.template');
        Route::post('/feedback/emailing', [AdminFeedbackController::class, 'emailing'])->name('feedback.emailing');
        Route::get('/feedback/create/{release?}', [AdminFeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback/store/{release?}', [AdminFeedbackController::class, 'store'])->name('feedback.store');
        Route::delete('/feedback/track/destroy/{track}', [AdminFeedbackController::class, 'destroyTrack'])->name('feedback.track.destroy');
        Route::resource('/feedback', AdminFeedbackController::class)->except(['show', 'create', 'store']);

        Route::name('school.')->prefix('school')->group(function(){

            Route::post('/courses/resort', [AdminSchoolCoursesController::class, 'resort'])->name('courses.resort');
            Route::resource('/courses', AdminSchoolCoursesController::class)->except(['show']);

            Route::post('/teachers/resort', [AdminSchoolTeachersController::class, 'resort'])->name('teachers.resort');;
            Route::resource('/teachers', AdminSchoolTeachersController::class)->except(['show']);

            Route::get('/cv/document/{cv}', [AdminSchoolCvController::class, 'document'])->name('cv.document');
            Route::resource('/cv', AdminSchoolCvController::class)->only(['index', 'show', 'destroy']);

        });

        Route::name('emailing.')->prefix('emailing')->group(function(){

            Route::post('/channels/start/test', [AdminEmailingChannelsController::class, 'startTest'])->name('channels.start.test');
            Route::post('/channels/start', [AdminEmailingChannelsController::class, 'start'])->name('channels.start');
            Route::post('/channels/stop', [AdminEmailingChannelsController::class, 'stop'])->name('channels.stop');
            Route::get('/channels/export/{channel}', [AdminEmailingChannelsController::class, 'export'])->name('channels.export');
            Route::resource('/channels', AdminEmailingChannelsController::class)->except(['show']);

            Route::get('/contacts/import', [AdminEmailingContactsController::class, 'import'])->name('contacts.import');
            Route::resource('/contacts', AdminEmailingContactsController::class)->except(['show']);

            Route::delete('/queue/clear', [AdminEmailingQueueController::class, 'clear'])->name('queue.clear');
            Route::delete('/queue/delete/{queue}', [AdminEmailingQueueController::class, 'destroy'])->name('queue.destroy');
            Route::get('/queue/problem', [AdminEmailingQueueController::class, 'problem'])->name('queue.problem');
            Route::get('/queue', [AdminEmailingQueueController::class, 'index'])->name('queue.index');

        });

    });
});
