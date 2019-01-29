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
Route::post('/add-list', 'HomeController@addList')->name('addList');
Route::post('/add-card', 'HomeController@addCard')->name('addCard');


/**
 * WS
 */
// DETAILS
Route::get('/cart-details', 'WSController@getListDetails')->name('cartDetails');
Route::get('/save-cart-details', 'WSController@saveCartDetails')->name('saveCartDetails');

//CHECKLIST
Route::get('/save-cart-checklist', 'WSController@saveCartChecklist')->name('saveCartChecklist');
Route::get('/get-cart-checklist', 'WSController@getCartChecklist')->name('getCartChecklist');
Route::get('/update-checklist', 'WSController@updateChecklist')->name('updateChecklist');
Route::get('/get-cart-comments', 'WSController@getCartsComment')->name('getComments');
Route::get('/save-comments', 'WSController@saveComments')->name('saveComments');