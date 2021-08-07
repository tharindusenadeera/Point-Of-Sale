<?php

use App\Http\Controllers\MenuItemController;
use Illuminate\Http\Resources\Json\ResourceResponse;
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

Route::get('/login', function () {
    return view('auth.login');
})->name("login");


Route::get("logout", function(){
  Auth::logout();
  return redirect('/');
});

Route::group([

  'namespace'=>'App\Http\Controllers',

], function(){

  Route::post("login", "UserController@login");

});


/*
|--------------------------------------------------------------------------
| Web Route /  Authenticated routes
|--------------------------------------------------------------------------
*/ 
Route::group([

    'middleware' => 'auth',
    'namespace'  => 'App\Http\Controllers',

], function(){

  Route::get('/', 'DashboardController@view');

 // users
 Route::post('users/{id}/status/{status}', "UserController@toggleStatus");
 Route::resource('users', UserController::class);


  Route::post('menu-item/{id}/{status}', "MenuItemController@toggleStatus");

  Route::resource('menu-item', 'MenuItemController');


  Route::post('menu-option-category/{id}/{status}', "MenuOptionCategotyController@toggleStatus");

  Route::resource('menu-option-category', 'MenuOptionCategotyController');


  Route::post('menu-option/{id}/{status}', "MenuOptionController@toggleStatus");

  Route::resource('menu-option', 'MenuOptionController');


  Route::post('category/{id}/{status}', "MenuCategoryController@toggleStatus");

  Route::resource('category', 'MenuCategoryController');

  Route::get('kitchen', 'KitchenController@index');
  Route::get('kitchen/orders', 'KitchenController@getOrders');

  //City crud resource routes and toggle status route
  Route::post('city/{id}/{status}','CityController@toggleStatus');
  Route::resource('city', 'CityController');
});
