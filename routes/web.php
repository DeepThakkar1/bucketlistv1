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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/categories/choose', 'CategoriesController@index');

Route::post('/categories/filters', 'CategoriesController@store');

Route::get('/budget/set', 'BudgetController@index');

Route::post('/budget/set', 'BudgetController@set');

Route::post('/carts', 'CartController@index');

Route::get('/orders', 'OrdersController@index');

Route::get('/carts/choose/{index}', 'CartController@choose');

Route::get('/carts/reorder/{order}', 'CartController@reorder');

Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'namespace' => 'Admin'], function()
{	
	CRUD::resource('products', 'ProductCrudController');
	CRUD::resource('categories', 'CategoryCrudController');
	CRUD::resource('sellers', 'SellerCrudController');
	CRUD::resource('attributes', 'AttributeCrudController');
	CRUD::resource('options', 'OptionCrudController');
});
