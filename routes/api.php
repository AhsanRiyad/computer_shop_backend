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


/* Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login'); */

// Route::get('products', 'Products\Products@index')->middleware('auth:api');

// /api/auth/

/* Route::group([
    'prefix' => 'auth'
], function () {
    
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');

        Route::get('products', 'Products\Products@index');
    });
});
 */
Route::group([], function () {

    Route::post('signin', 'Api\AuthController@signin');
    Route::post('signup', 'Api\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {

        Route::get('signout', 'Api\AuthController@signout');
        Route::get('user', 'Api\AuthController@user');

        //test
        
        //category
        Route::get('inventory/category', 'Categories\Category@index');
        Route::get('inventory/category/{id}', 'Categories\Category@show');
        Route::post('inventory/category', 'Categories\Category@store');
        Route::put('inventory/category/{id}', 'Categories\Category@update');
        Route::delete('inventory/category/{id}', 'Categories\Category@destroy');
        //bulk create
        Route::post('inventory/categories', 'Categories\Category@create');


        //brand
        Route::get('inventory/brand', 'Brands\Brand@index');
        Route::get('inventory/brand/{id}', 'Brands\Brand@show');
        Route::post('inventory/brand', 'Brands\Brand@store');
        Route::put('inventory/brand/{id}', 'Brands\Brand@update');
        Route::delete('inventory/brand/{id}', 'Brands\Brand@destroy');
        //bulk create
        Route::post('inventory/brands', 'Brands\Brand@create');

        //product
        Route::get('inventory/product', 'Products\Product@index');
        Route::get('inventory/product/{id}', 'Products\Product@show');
        Route::post('inventory/product', 'Products\Product@store');
        Route::put('inventory/product/{id}', 'Products\Product@update');
        Route::delete('inventory/product/{id}', 'Products\Product@destroy');
        //bulk create
        Route::post('inventory/products', 'Products\Product@create');

        //salary
        Route::get('salary', 'Salary\Salary@index');
        Route::get('salary/{id}', 'Salary\Salary@show');
        Route::post('salary', 'Salary\Salary@store');
        Route::put('salary/{id}', 'Salary\Salary@update');
        Route::delete('salary/{id}', 'Salary\Salary@destroy');
        //bulk create
        Route::post('salaries', 'Salary\Salary@create');

        //Client
        Route::get('clients', 'Clients\Client@index');
        Route::get('client/{id}', 'Clients\Client@show');
        Route::post('client', 'Clients\Client@store');
        Route::put('client/{id}', 'Clients\Client@update');
        Route::delete('client/{id}', 'Clients\Client@destroy');
        //bulk create
        Route::post('clients', 'Clients\Client@create');

        //Order
        Route::get('orders', 'Orders\Order@index');
        Route::get('order/{id}', 'Orders\Order@show');
        Route::post('order', 'Orders\Order@store');
        Route::put('order/{id}', 'Orders\Order@update');
        Route::delete('order/{id}', 'Orders\Order@destroy');
        //bulk create
        Route::post('orders', 'Orders\Order@create');


        //Transaction
        Route::get('transactions', 'Transactions\Transaction@index');
        Route::get('transaction/{id}', 'Transactions\Transaction@show');
        Route::post('transaction', 'Transactions\Transaction@store');
        Route::put('transaction/{id}', 'Transactions\Transaction@update');
        Route::delete('transaction/{id}', 'Transactions\Transaction@destroy');

        Route::get('transactions/order/{order_id}', 'Transactions\Transaction@show_by_order');
        Route::post('transaction/order/{order_id}', 'Transactions\Transaction@store_by_order');

        Route::get('transactions/client/{client_id}', 'Transactions\Transaction@show_by_client');
        Route::post('transaction/client/{client_id}', 'Transactions\Transaction@store_by_client');

        //bulk create
        Route::post('transactions', 'Transactions\Transaction@create');
    });
});

        

  