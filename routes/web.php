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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// 用户注册管理
Route::get('signup','UsersController@create')->name('signup');
Route::resource('users','UsersController');

// 用户登陆会话
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('login', 'SessionsController@destroy')->name('logout');

// 调查问卷
Route::resource('surveys', 'SurveysController');

// 问卷设计页
Route::get('create/{survey}', 'SurveyDesignController@index')->name('create');
Route::get('preview/{survey}','SurveyDesignController@preview')->name('preview');
Route::get('test', 'SurveyDesignController@test');

Route::resource('surveypages', 'SurveyPagesController');
Route::post('surveypages/sort', 'SurveyPagesController@sort');

// Route::resource('questions', 'QuestionsController');
Route::get('questions/{question}', 'QuestionsController@show')->name('questions.show');
Route::post('questions/create', 'QuestionsController@create');
Route::post('questions/store', 'QuestionsController@store');
Route::post('questions/edit', 'QuestionsController@edit');
Route::post('questions/update', 'QuestionsController@update');
Route::post('questions/destroy', 'QuestionsController@destroy');
Route::post('questions/sort', 'QuestionsController@sort');
Route::post('questions/undel', 'QuestionsController@undel');
