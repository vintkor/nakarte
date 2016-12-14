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

Route::get('/home', function (){ return redirect()->route('home'); });
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@show_all_problems']);

Route::get('/ajax_all_problems',             ['as' => 'ajax_all_problems',        'uses' => 'HomeController@ajax_all_problems']);
Route::get('/ajax_categories_problems/{id}', ['as' => 'ajax_categories_problems', 'uses' => 'HomeController@ajax_categories_problems']);
Route::get('/add_problems', 	             ['as' => 'add_problems'	 ,           'uses' => 'HomeController@add_problems_get']);
Route::post('/add_problems', 	             ['as' => 'add_problems'	 ,           'uses' => 'HomeController@add_problems_post']);

Route::get('/problem/{slug}', ['as' => 'single_problem_get', 'uses' => 'HomeController@single_problem_get']);

/*================= Пользователь ===============*/

Route::get('/profile', ['as' => 'profile', 'uses' => 'userController@index']);
Route::post('/profile',['as' => 'profile', 'uses' => 'userController@update_profile']);

Auth::routes();
