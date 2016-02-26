<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

//Route::get('home', 'HomeController@index');

Route::get('/', 'HomeController@index');

Route::get('userList', 'UserController@index');
Route::post('userList', 'UserController@index');

Route::get('projectList', 'ProjectController@index');
Route::post('projectList', 'ProjectController@index');


Route::resource('users', 'UserController');
Route::resource('projects', 'ProjectController');

Route::get('suggest-auto', 'SuggestAutoController@index');
Route::get('refresh-locality', 'SuggestAutoController@refreshLocality');
Route::get('refresh-suburb', 'SuggestAutoController@refreshSuburb');
Route::get('refresh-projectType', 'SuggestAutoController@refreshProjectType');
Route::get('search-company-term', 'SuggestAutoController@getCompanyNamesByTypeTerm');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
