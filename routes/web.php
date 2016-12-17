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
Route::get('/','HomeController@show_all_problems')->name('home');

Route::get('/ajax_all_problems', 'HomeController@ajax_all_problems')
	->name('ajax_all_problems');

Route::get('/ajax_categories_problems/{id}', 'HomeController@ajax_categories_problems')
	->name('ajax_categories_problems');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/add_problems', 'HomeController@add_problems_get')->name('add_problems');	
});

Route::post('/add_problems', 'HomeController@add_problems_post')
	->name('add_problems');

Route::get('/problem/{slug}', ['as' => 'single_problem_get', 'uses' => 'HomeController@single_problem_get']);

/*================= Пользователь ===============*/

Route::get('/profile', 'userController@index')->name('profile');
Route::post('/profile', 'userController@update_profile')->name('profile');

Auth::routes();
