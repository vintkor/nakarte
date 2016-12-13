<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/home', function (){ return redirect()->route('home'); });

/*================= Пользователь ===============*/

Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@index']);
Route::post('/profile',['as' => 'profile', 'uses' => 'UserController@update_profile']);

Auth::routes();
