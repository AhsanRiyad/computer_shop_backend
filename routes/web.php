<?php

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

Route::get('/', function () {
    return view('welcome');
});


		//category
        Route::get('inventory/category', 'Categories\Category@index');
        Route::get('inventory/category/{id}', 'Categories\Category@show');
        Route::post('inventory/category', 'Categories\Category@store');
        Route::put('inventory/category/{id}', 'Categories\Category@update');
        Route::delete('inventory/category/{id}', 'Categories\Category@destroy');
        //bulk create
        Route::post('inventory/categories', 'Categories\Category@create');