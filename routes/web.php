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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard/{id}', 'HomeController@dashboard')->name('dashboard');

Route::post('/add-dashboard', 'HomeController@add')->name('add');
Route::post('/add-card', 'HomeController@addCard')->name('addCard');
