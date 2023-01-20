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

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/{gallery_id}','App\Http\Controllers\HomeController@delete')->name('delete');

Route::get('/register/delete/{user_id}','App\Http\Controllers\Auth\RegisterController@delete_user')->name('delete_user');

Route::get('/register/edit/{user_id}','App\Http\Controllers\Auth\RegisterController@edit_user')->name('edit_user');
Route::post('/register/edit/{user_id}','App\Http\Controllers\Auth\RegisterController@edit_user')->name('edit_user');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');


