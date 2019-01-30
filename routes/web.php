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

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

Route::get('users/payment_panel', [
	'as' => 'users.paymentPanel',
	'uses' => 'UserController@paymentPanel'
]);

Route::get('users/payment_panel/confirm/{id}', [
	'as' => 'users.confirmPayment',
	'uses' => 'UserController@confirmPayment'
]);

Route::resource('users', 'UserController');


Route::resource('plans', 'PlanController');

Route::resource('plans', 'PlanController');