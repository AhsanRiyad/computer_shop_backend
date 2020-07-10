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

    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {

        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');

        //products
        Route::get('products', 'Products\Products@index');
        Route::get('product/{id}', 'Products\Products@show');
        Route::post('product', 'Products\Products@store');
        Route::put('product/{id}', 'Products\Products@update');
        Route::delete('product/{id}', 'Products\Products@destroy');

        //serials
        Route::get('serials', 'Products\Serials@index');
        Route::get('serial/{id}', 'Products\Serials@show');
        Route::post('serial', 'Products\Serials@store');
        Route::put('serial/{id}', 'Products\Serials@update');
        Route::delete('serial/{id}', 'Products\Serials@destroy');

        //category
        Route::get('categories', 'products\categories@index');
        Route::get('category/{id}', 'products\categories@show');
        Route::post('category', 'products\categories@store');
        Route::put('category/{id}', 'products\categories@update');
        Route::delete('category/{id}', 'products\categories@destroy');

        //brands
        Route::get('brands', 'products\brands@index');
        Route::get('brand/{id}', 'products\brands@show');
        Route::post('brand', 'products\brands@store');
        Route::put('brand/{id}', 'products\brands@update');
        Route::delete('brand/{id}', 'products\brands@destroy');

        //brands
        Route::get('brands', 'products\brands@index');
        Route::get('brand/{id}', 'products\brands@show');
        Route::post('brand', 'products\brands@store');
        Route::put('brand/{id}', 'products\brands@update');
        Route::delete('brand/{id}', 'products\brands@destroy');

        //clients
        Route::get('clients', 'clients\clients@index');
        Route::get('client/{id}', 'clients\clients@show');
        Route::post('client', 'clients\clients@store');
        Route::put('client/{id}', 'clients\clients@update');
        Route::delete('client/{id}', 'clients\clients@destroy');


        // orders
        



        // transactions




    });
});
