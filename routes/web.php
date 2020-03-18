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

Route::group(['middleware' => 'i18n'], function(){

    Auth::routes();
    Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook')->name('auth.facebook');
    Route::get('auth/google', 'Auth\LoginController@redirectToGoogle')->name('auth.google');
    Route::get('auth/google/handle', 'Auth\LoginController@handleGoogleCallback');

    Route::get('/profile', 'ProfileController@index')->name('profile');

    Route::get('/', 'ReleasesController@index')->name('home');
    Route::get('/search', 'ReleasesController@index')->name('search');
    Route::get('/releases/{id}', 'ReleasesController@show')->name('release');
    Route::get('/artists', 'ArtistsController@index')->name('artists');
    Route::get('/reviews', 'ReviewsController@index')->name('reviews');
    Route::get('/about.html', 'AppController@about')->name('about');
    Route::get('/studio.html', 'AppController@studio')->name('studio');
    Route::get('/ctschool.html', 'AppController@ctschool')->name('school');
    Route::any('/feedback/{slug}', 'FeedbackController@show')->name('feedback');
    Route::get('/feedback/{slug}/end', 'FeedbackController@end')->name('feedback.end');

    Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {

        Route::any('/cts-admin/{controller}/{action}/{id?}/{param?}', function($controller, $action, $id = null, $param = null){
            $app = app();
            try{
                $controller_name = explode('_', $controller);
                $fixed_name = array();
                foreach($controller_name as $name){
                    $fixed_name[] = ucfirst($name);
                }
                $controller = implode('', $fixed_name);

                $controller = $app->make('\App\Http\Controllers\Admin\Admin'.ucfirst($controller).'Controller');
                if(!method_exists($controller, $action)) throw new ReflectionException();;
                return $controller->callAction($action, $parameters = array(Request::instance(), $id, $param));
            }catch(ReflectionException $e){
                abort(404);
            }
        });

        Route::get('/cts-admin', 'AdminController@index')->name('admin');
        Route::get('/cts-admin/releases', 'AdminReleasesController@index')->name('releases_admin');
        Route::get('/cts-admin/artists', 'AdminArtistsController@index')->name('artists_admin');
        Route::get('/cts-admin/reviews', 'AdminReviewsController@index')->name('reviews_admin');
        Route::get('/cts-admin/feedback', 'AdminFeedbackController@index')->name('feedback_admin');
        Route::get('/cts-admin/school', 'AdminSchoolController@index')->name('school_admin');
        Route::get('/cts-admin/studio', 'AdminStudioController@index')->name('studio_admin');
        Route::get('/cts-admin/users', 'AdminUsersController@index')->name('users_admin');

    });

});
