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

Route::get('/','SessionController@createLogin')->name('login');
Route::post('/login', 'SessionController@login');
Route::get('/logout', 'SessionController@logout');

Route::get('/signup', 'RegistrationController@createUser');
Route::post('/register', 'RegistrationController@register');

Route::get('/transactions', 'TransactionController@transactions')->name('index');
Route::get('/transacs', 'TransactionController@tran');
Route::get('/create', 'TransactionController@create');
Route::post('/transfer', 'TransactionController@transfer');
