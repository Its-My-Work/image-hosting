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

//Auth::routes();
Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/home/{gallery_id}','App\Http\Controllers\HomeController@delete')->name('delete_gallery');
Route::post('/home', 'App\Http\Controllers\HomeController@create');

Route::get('/login', 'App\Http\Controllers\LoginController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@authenticate')->name('login');

Route::get('/register', 'App\Http\Controllers\RegisterController@showRegistrationForm')->name('register');
Route::get('/register/edit/{user_id}','App\Http\Controllers\RegisterController@edit_user')->name('edit_user');
Route::get('/register/delete/{user_id}','App\Http\Controllers\RegisterController@delete_user')->name('delete_user');
Route::post('/register/edit/{user_id}','App\Http\Controllers\RegisterController@edit_user');
Route::post('/register','App\Http\Controllers\RegisterController@create');

Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');




Route::get('/password/forgot', 'App\Http\Controllers\ResetPasswordController@reset_link_form')->middleware('guest')->name('password.reset_link');
Route::post('/password/forgot', 'App\Http\Controllers\ResetPasswordController@reset_link_send')->middleware('guest')->name('password.send_link');
Route::get('/password/reset', 'App\Http\Controllers\ResetPasswordController@reset_link_form')->middleware('guest')->name('password.reset');
Route::post('/password/reset', 'App\Http\Controllers\ResetPasswordController@change_password')->middleware('guest')->name('password.reset2');
