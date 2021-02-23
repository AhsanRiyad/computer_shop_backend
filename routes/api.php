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
    
    
    Route::get('test', function(){
        // return request()->url();
        /* return request()->path();
        if( request()->path('test') ){
            return 'test';
        }; */

        return auth()->guest();
        // return auth()->user();
        // return auth()->check();


    });


    Route::group([
        'middleware' => 'auth:api'
    ], function () {

        Route::get('signout', 'Api\AuthController@signout');
        Route::get('user', 'Api\AuthController@user');

        //test
        
        //search
        Route::get('search/category', 'Categories\Category@search');
        Route::get('search/brand', 'Brands\Brand@search');
        Route::get('search/client', 'Clients\Client@search');
        Route::get('search/purchase', 'Orders\Order@searchPurchase');
        Route::get('search/sell', 'Orders\Order@searchSell');
        Route::get('search/product', 'Products\Product@search');
        Route::get('search/transaction', 'Transactions\Transaction@search');


        //dropdown
        Route::get('dropdown/category', 'Categories\Category@dropdown');
        Route::get('dropdown/brand', 'Brands\Brand@dropdown');
        Route::get('dropdown/product', 'Products\Product@dropdown');
        Route::get('dropdown/seller', 'Clients\Client@index_seller');
        Route::get('dropdown/customer', 'Clients\Client@index_customer');
        Route::get('dropdown/client', 'Clients\Client@index_client');

        Route::get('dropdown/product_n_serial', 'Products\Product@index_product_n_serial');

        //serials
        Route::get('serial', 'Products\Serial_number@index');


        //category
        Route::get('category', 'Categories\Category@index');
        Route::get('category', 'Categories\Category@index');
        Route::get('category/{id}', 'Categories\Category@show');
        Route::post('category', 'Categories\Category@store');
        Route::put('category/{id}', 'Categories\Category@update');
        Route::delete('category/{id}', 'Categories\Category@destroy');
        //bulk create
        Route::post('categories', 'Categories\Category@create');


        //brand
        Route::get('brand', 'Brands\Brand@index');
        Route::get('brand/{id}', 'Brands\Brand@show');
        Route::post('brand', 'Brands\Brand@store');
        Route::put('brand/{id}', 'Brands\Brand@update');
        Route::delete('brand/{id}', 'Brands\Brand@destroy');
        //bulk create
        Route::post('brands', 'Brands\Brand@create');

        //product
        Route::get('product', 'Products\Product@index');
        Route::get('product/{id}', 'Products\Product@show');
        Route::post('product', 'Products\Product@store');
        Route::put('product/{id}', 'Products\Product@update');
        Route::delete('product/{id}', 'Products\Product@destroy');
        //bulk create
        Route::post('products', 'Products\Product@create');

        //salary
        Route::get('salary', 'Salary\Salary@index');
        Route::get('salary/{id}', 'Salary\Salary@show');
        Route::post('salary', 'Salary\Salary@store');
        Route::put('salary/{id}', 'Salary\Salary@update');
        Route::delete('salary/{id}', 'Salary\Salary@destroy');
        //bulk create
        Route::post('salaries', 'Salary\Salary@create');

        //Client
        Route::get('client', 'Clients\Client@index');

        Route::get('clients/seller', 'Clients\Client@index_seller');
        Route::get('clients/customer', 'Clients\Client@index_customer');


        Route::get('client/{id}', 'Clients\Client@show');
        Route::post('client', 'Clients\Client@store');
        Route::put('client/{id}', 'Clients\Client@update');
        Route::delete('client/{id}', 'Clients\Client@destroy');
        //bulk create
        Route::post('clients', 'Clients\Client@create');

        //Order
        Route::get('order', 'Orders\Order@index');
        Route::get('order/{id}', 'Orders\Order@show');
        Route::post('order', 'Orders\Order@store');
        Route::put('order/{id}', 'Orders\Order@update');
        Route::delete('order/{id}', 'Orders\Order@destroy');

        //print invoice
        Route::post('order/invoice/{order_id}', 'Orders\Order@printInvoice');

        //bulk create
        Route::post('orders', 'Orders\Order@create');


        //sell
        Route::get('sell', 'Orders\Order@index_sell');
        Route::post('sell', 'Orders\Order@store_sell');
        Route::put('sell/{id}', 'Orders\Order@update_sell');


        //Transaction
        Route::get('transaction', 'Transactions\Transaction@index');
        Route::get('transaction/{id}', 'Transactions\Transaction@show');
        Route::post('transaction', 'Transactions\Transaction@store');
        Route::put('transaction/{id}', 'Transactions\Transaction@update');
        Route::delete('transaction/{id}', 'Transactions\Transaction@destroy');

        
        Route::get('transaction/order/{order_id}', 'Transactions\Transaction@show_by_order');
        Route::post('transaction/order/{order_id}', 'Transactions\Transaction@store_by_order');
        Route::put('transaction/order/{order_id}/{transaction_id}', 'Transactions\Transaction@update_by_order');


        Route::get('transactions/client/{client_id}', 'Transactions\Transaction@show_by_client');
        Route::post('transaction/client/{client_id}', 'Transactions\Transaction@store_by_client');

        //bulk create
        Route::post('transactions', 'Transactions\Transaction@create');
        

        //Reports
        Route::get('overallReports', 'Reports\Report@overallReports');
        Route::get('productReports/{product_id}', 'Reports\Report@productReports');
        Route::get('categoryReports/{category_id}', 'Reports\Report@categoryReports');

        
    });
});

        

  