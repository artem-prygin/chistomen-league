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
                'except' => ['index', 'show'],
            ]
        );
    });
Route::get('/posts/{id}', 'PostController@show')->name('posts-show');
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
                'except' => ['create', 'store', 'edit', 'uploadAvatar', 'changeGroup', 'destroy'],
            ]
        );
    });

Route::post('/profile/uploadAvatar', 'UserMetaController@uploadAvatar')->middleware('auth');
Route::put('/profile/changeGroup', 'UserMetaController@changeGroup')->middleware('auth');
Route::delete('/profile/{profile}', 'UserMetaController@destroy')->middleware('auth')->name('profile.destroy');
Route::get('/league', 'UserMetaController@leagueList')->middleware('auth')->name('league');

/**
 * MapController
 */
Route::get('/map', 'MapController@index')->middleware('auth')->name('map');


/**
 * GroupController
 */
Route::get('/group/{slug}', 'GroupController@show')->middleware('auth')->name('group');
Route::get('/group', 'HomeController@index')->name('main');

/**
 * ManagerController
 */
Route::get('/manager', 'ManagerController@index')->middleware('isAdmin')->name('manager');
Route::get('/manager/groups', 'ManagerController@groups')->middleware('isAdmin')->name('manager-groups');
Route::get('/manager/groups/create', 'ManagerController@groups_create')->middleware('isAdmin')->name('manager-groups-create');
Route::post('/manager/groups', 'ManagerController@groups_store')->middleware('isAdmin')->name('manager-groups-store');
Route::get('/manager/groups/{group}', 'ManagerController@groups_edit')->middleware('isAdmin')->name('manager-groups-edit');
Route::put('/manager/groups/{group}', 'ManagerController@groups_update')->middleware('isAdmin')->name('manager-groups-update');
Route::delete('/manager/groups/{group}', 'ManagerController@groups_destroy')->middleware('isAdmin')->name('manager-groups-destroy');

/**
 * Yaubral / Я убрал
 */
Route::get('/yaubral', 'YaubralController@index')->name('yaubral');
Route::get('/yaubral/all', 'YaubralController@showAll')->name('yaubral.showAll');
Route::get('/yaubral/{week}', 'YaubralController@show')->name('yaubral.show');
Route::post('/yaubral', 'YaubralController@store')->name('yaubral.store');
Route::post('/yaubral/postConfirm', 'YaubralController@postConfirm')->name('yaubral.postConfirm');
Route::post('/yaubral/postDecline', 'YaubralController@postDecline')->name('yaubral.postDecline');
Route::post('/yaubral/getWinner', 'YaubralController@getWinner')->name('yaubral.getWinner');
Route::post('/yaubral/{week}', 'YaubralController@addVideo')->name('yaubral.addVideo');
