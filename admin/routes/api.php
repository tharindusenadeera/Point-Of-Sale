<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers\v1',
    'prefix'     => 'v1'

], function ($router) {

    //done
    Route::get('/categories'          , 'CategoryController@getCategories');

    //done
    Route::get('/menu-items'          , 'MenuItemController@getMenuItems');

     //done
    Route::get('/cities'               , 'CityController@getAllCities');

    //done
    Route::post('/new-customer'       , 'CustomerController@createCustomer');

    // done
    Route::get('/customers'           , 'CustomerController@getAllCustomer');

    // done
    Route::get('/customer/{id}'       , 'CustomerController@getCustomer');



    

    // pending
    Route::post('/new-order'       , 'OrderController@createOrder');
    // pending
    Route::get('/edit-order/{id}'  , 'OrderController@editOrder');
    // pending
    Route::get('/orders'           , 'OrderController@getAllOrders');
    // pending
    Route::get('/get-order/{id}'  , 'OrderController@getOrder');
});

