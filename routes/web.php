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

//DASHBOARD
Route::get('/update-dashboard-favorite', 'WSController@updateFavorite')->name('updateDashboardFavorite');
Route::get('/update-dashboard-main/{id}', 'WSController@updateMainDashboard')->name('updateMainDashboard');

//ETIQUETTES
Route::get('/add-etiquette', 'WSController@addEtiquette')->name('addEtiquette');
Route::get('/etiquette-list', 'WSController@etiquettesList')->name('etiquettesList');
Route::get('/insert-delete-etiquette', 'WSController@insertOrDeleteEtiquette')->name('insertOrDeleteEtiquette');
Route::get('/check-etiquette-task', 'WSController@checkEtiquette')->name('checkEtiquette');
Route::get('/update-etiquette-list/{id}', 'WSController@updateEtiquetteList')->name('updateEtiquetteList');