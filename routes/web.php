<?php

use Illuminate\Support\Facades\Route;

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


/**
 * PostController
 */
Route::get('/', 'HomeController@index')->name('main');
Route::get('/posts', 'PostController@index')->name('posts');
Route::get('/posts/category/{id}', 'PostController@showCategoryPosts')->name('posts-category');
Route::get('/posts/user/{nickname}', 'PostController@showUserPosts')->name('posts-user');
Route::get('/posts/group/{slug}', 'PostController@showGroupPosts')->name('posts-group');

Route::group(['middleware' => ['auth']],
    function () {
        Route::resource('/posts', 'PostController',
            [
                'except' => ['index'],
            ]
        );
    });
Route::post('/like', 'PostController@like')->middleware('auth')->name('like');


/**
 * Auth
 */
Auth::routes(['verify' => true]);

/**
 * UserMetaController
 */
Route::group(['middleware' => ['auth']],
    function () {
        Route::resource('/profile', 'UserMetaController',
            [
                'except' => ['create', 'store', 'edit', 'uploadAvatar', 'changeGroup'],
            ]
        );
    });

Route::post('/profile/uploadAvatar', 'UserMetaController@uploadAvatar')->middleware('auth');
Route::put('/profile/changeGroup', 'UserMetaController@changeGroup')->middleware('auth');
Route::get('/league', 'UserMetaController@leagueList')->middleware('auth')->name('league');

/**
 * MapController
 */
Route::get('/map', 'MapController@index')->middleware('auth')->name('map');



/**
 * GroupController
 */
Route::get('/group/{slug}', 'GroupController@show')->middleware('auth')->name('group');


