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

Route::get('/', 'IndexController@show')->name('index');

// Auth
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Tag
Route::get('tags/', 'TagController@index')->name('tags');
Route::get('tag/{name}', 'TagController@show')->name('tag');

// User
Route::get('@{screen_name}', 'UserController@show')->name('user');
Route::get('@{screen_name}/edit', 'UserController@show')->name('user.edit');
Route::post('@{screen_name}/edit', 'UserController@edit')->name('user.update');

// Post
Route::get('@{screen_name}/create', 'PostController@create')->name('post.create');
Route::post('@{screen_name}/create', 'PostController@store')->name('post.store');
Route::get('@{screen_name}/{slug}', 'PostController@show')->name('post');
Route::get('@{screen_name}/{slug}/edit', 'PostController@edit')->name('post.edit');
Route::Post('@{screen_name}/{slug}/edit', 'PostController@update')->name('post.update');

