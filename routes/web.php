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

Route::get('/','TopicController@index')->name('root');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//UserController
Route::resource('users','UserController',['only' => ['show','update','edit']]);
Route::get('users/{user}/followers','UserController@followers')->name('users.followers');
Route::get('users/{user}/followings','UserController@followings')->name('users.followings');

Route::post('followers/{user}','FollowerController@follow')->name('followers.follow');
Route::delete('followers/{user}','FollowerController@unfollow')->name('followers.unfollow');

Route::resource('topics', 'TopicController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicController@show')->name('topics.show');

Route::post('upload_image', 'TopicController@uploadImage')->name('topics.upload_image');

Route::resource('categories', 'CategoryController', ['only' => ['show']]);


Route::resource('replies', 'ReplyController', ['only' => ['store','destroy']]);

Route::resource('notifications', 'NotificationController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

Route::get('usersjson','UserController@usersjson');