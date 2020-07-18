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
        Route::get('categories', 'Categories\Category@index');
        Route::get('category/{id}', 'Categories\Category@show');
        Route::post('category', 'Categories\Category@store');
        Route::put('category/{id}', 'Categories\Category@update');
        Route::delete('category/{id}', 'Categories\Category@destroy');
        //bulk create
        Route::post('categories', 'Categories\Category@create');
        

        
        //brand
        Route::get('brands', 'Brands\Brand@index');
        Route::get('brand/{id}', 'Brands\Brand@show');
        Route::post('brand', 'Brands\Brand@store');
        Route::put('brand/{id}', 'Brands\Brand@update');
        Route::delete('brand/{id}', 'Brands\Brand@destroy');
        //bulk create
        Route::post('brands', 'Brands\Brand@create');

        //product
        Route::get('products', 'Products\Product@index');
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
        
        




    });
});
