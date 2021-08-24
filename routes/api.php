<?php

use App\Http\Controllers\Incomes\IncomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Microcredit\Dps\Dps;
use App\Http\Controllers\Microcredit\Loans\Loan;

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

/* 
    Route::group([
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
        Route::get('search/product/{branch_id}', 'Products\Product@search');
        Route::get('search/transaction', 'Transactions\Transaction@search');

        //dropdown
        Route::get('dropdown/category', 'Categories\Category@dropdown');
        Route::get('dropdown/brand', 'Brands\Brand@dropdown');
        Route::get('dropdown/product/{branch_id}', 'Products\Product@dropdown');
        Route::get('dropdown/branch', 'Branches\Branch@dropdown');
        Route::get('dropdown/seller', 'Clients\Client@index_seller');
        Route::get('dropdown/customer', 'Clients\Client@index_customer');
        Route::get('dropdown/client', 'Clients\Client@index_client');
        Route::get('dropdown/unit', 'Units\Unit@dropdown');
        Route::get('dropdown/bank', 'Banks\Bank@dropdown');
        Route::get('dropdown/member', 'Microcredit\Members\Member@dropdown');
        Route::get('dropdown/employee', 'Employees\Employee@dropdown');
        Route::get('dropdown/dps', [Dps::class, 'dropdown']);
        Route::get('dropdown/loan', [Loan::class, 'dropdown']);
        Route::get('dropdown/income-name', [IncomeController::class, 'dropdown']);

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

        //branch
        Route::get('branch', 'Branches\Branch@index');
        Route::get('branch/product', 'Branches\Branch@product');
        Route::get('branch/{id}', 'Branches\Branch@index');
        Route::get('branch/{id}', 'Branches\Branch@show');
        Route::post('branch', 'Branches\Branch@store');
        Route::put('branch/{id}', 'Branches\Branch@update');
        Route::delete('branch/{id}', 'Branches\Branch@destroy');

        //bank
        Route::get('bank', 'Banks\Bank@index');
        Route::get('bank/{id}', 'Banks\Bank@index');
        Route::get('bank/{id}', 'Banks\Bank@show');
        Route::post('bank', 'Banks\Bank@store');
        Route::put('bank/{id}', 'Banks\Bank@update');
        Route::delete('bank/{id}', 'Banks\Bank@destroy');

        //income
        Route::get('income-name', 'Incomes\IncomeController@indexIncomeName');
        Route::get('income-name/{id}', 'Incomes\IncomeController@showIncomeName');
        Route::post('income-name', 'Incomes\IncomeController@storeIncomeName');
        Route::put('income-name/{id}', 'Incomes\IncomeController@updateIncomeName');
        Route::delete('income-name/{id}', 'Incomes\IncomeController@destroyIncomeName');
        
        //store income
        Route::get('income', 'Incomes\IncomeController@indexIncome');
        Route::post('income', 'Incomes\IncomeController@storeIncome');
        

        //expense
        Route::get('expense-name', 'Expenses\ExpenseController@indexExpenseName');
        Route::get('expense-name/{id}', 'Expenses\ExpenseController@showExpenseName');
        Route::post('expense-name', 'Expenses\ExpenseController@storeExpenseName');
        Route::put('expense-name/{id}', 'Expenses\ExpenseController@updateExpenseName');
        Route::delete('expense-name/{id}', 'Expenses\ExpenseController@destroyExpenseName');

        //unit
        Route::get('unit', 'Units\Unit@index');
        Route::get('unit/{id}', 'Units\Unit@index');
        Route::get('unit/{id}', 'Units\Unit@show');
        Route::post('unit', 'Units\Unit@store');
        Route::put('unit/{id}', 'Units\Unit@update');
        Route::delete('unit/{id}', 'Units\Unit@destroy');

        //brand
        Route::get('brand', 'Brands\Brand@index');
        Route::get('brand/{id}', 'Brands\Brand@show');
        Route::post('brand', 'Brands\Brand@store');
        Route::put('brand/{id}', 'Brands\Brand@update');
        Route::delete('brand/{id}', 'Brands\Brand@destroy');
        //bulk create
        Route::post('brands', 'Brands\Brand@create');

        //product
        Route::get('product/{branch_id}', 'Products\Product@index');
        Route::get('product/{id}', 'Products\Product@show');
        Route::post('product', 'Products\Product@store');
        Route::post('product/{id}', 'Products\Product@update');
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

        Route::get('clients/seller', 'Clients\Client@getAllSeller');

        Route::get('clients/customer', 'Clients\Client@getAllCustomer');

        Route::get('client/{id}', 'Clients\Client@show');
        Route::post('client', 'Clients\Client@store');
        Route::put('client/{id}', 'Clients\Client@update');
        Route::delete('client/{id}', 'Clients\Client@destroy');
        //bulk create
        Route::post('clients', 'Clients\Client@create');

        
        //Order
        Route::get('order/{branch_id}', 'Orders\Order@index');
        Route::get('order-on-credit/{branch_id}', 'Orders\Order@indexOrderOnCredit');
        Route::get('order/test', 'Orders\Order@test');
        Route::get('orderReqiredData', 'Orders\Order@orderReqiredData');
        Route::get('order-details/{id}', 'Orders\Order@show');
        Route::post('order', 'Orders\Order@store');
        Route::put('order/{id}', 'Orders\Order@update');
        Route::delete('order/{id}', 'Orders\Order@destroy');
        
        //print invoice
        Route::post('order/invoice/{order_id}', 'Orders\Order@printInvoice');
        Route::post('order/invoice', 'Orders\Order@printInvoiceByInfo');

        //bulk create
        Route::post('orders', 'Orders\Order@create');

        //sell
        Route::get('sell/{branch_id}', 'Orders\Order@index_sell');

        //Transaction
        Route::get('transaction', 'Transactions\Transaction@index');
        Route::get('transaction/{id}', 'Transactions\Transaction@show');
        Route::post('transaction', 'Transactions\Transaction@store');
        Route::put('transaction/{id}', 'Transactions\Transaction@update');
        Route::delete('transaction/{id}', 'Transactions\Transaction@destroy');
        Route::get('transactionByClient', 'Transactions\Transaction@transactionByClient');
        Route::get('transactionBySeller', 'Transactions\Transaction@transactionBySeller');
        Route::get('transactionByCustomer', 'Transactions\Transaction@transactionByCustomer');
        Route::get('transactionLedger/{period}/{client_id}', 'Transactions\Transaction@transactionLedger');

        Route::get('transaction/order/{order_id}', 'Transactions\Transaction@show_by_order');
        Route::post('transaction/order/{order_id}', 'Transactions\Transaction@store_by_order');
        Route::put('transaction/order/{order_id}/{transaction_id}', 'Transactions\Transaction@update_by_order');
        Route::get('transaction/order/{order_id}/{id}', 'Transactions\Transaction@show');

        Route::get('transactions/client/{client_id}', 'Transactions\Transaction@show_by_client');
        Route::post('transaction/client/{client_id}', 'Transactions\Transaction@store_by_client');
        
        Route::get('incomeStatement/{period}', 'Transactions\Transaction@incomeStatement');

        //for income
        Route::get('transactions/income', 'Incomes\IncomeController@indexIncome');
        Route::post('transactions/income', 'Incomes\IncomeController@storeIncome');
        Route::put('transactions/income/{id}', 'Transactions\Transaction@update');

        //for expense
        Route::get('transactions/expense', 'Expenses\ExpenseController@indexExpense');
        Route::post('transactions/expense', 'Expenses\ExpenseController@storeExpense');
        Route::put('transactions/expense/{id}', 'Transactions\Transaction@update');

        //bulk create
        Route::post('transactions', 'Transactions\Transaction@create');

        //Reports
        Route::get('overallReports', 'Reports\Report@overallReports');
        Route::get('productReports/{product_id}', 'Reports\Report@productReports');
        Route::get('categoryReports/{category_id}', 'Reports\Report@categoryReports');

        //Microcredit
        //Member
        Route::get('member', 'Microcredit\Members\Member@index');
        Route::get('member/{id}', 'Microcredit\Members\Member@show');
        Route::post('member', 'Microcredit\Members\Member@store');
        Route::put('member/{id}', 'Microcredit\Members\Member@update');
        Route::delete('member/{id}', 'Microcredit\Members\Member@destroy');
        
        //Loan
        Route::get('loan', 'Microcredit\Loans\Loan@index');
        Route::get('loan/{id}', 'Microcredit\Loans\Loan@show');
        Route::post('loan', 'Microcredit\Loans\Loan@store');
        Route::put('loan/{id}', 'Microcredit\Loans\Loan@update');
        Route::delete('loan/{id}', 'Microcredit\Loans\Loan@destroy');

        //dps
        Route::get('dps', 'Microcredit\Dps\Dps@index');
        Route::get('dps/{id}', 'Microcredit\Dps\Dps@show');
        Route::post('dps', 'Microcredit\Dps\Dps@store');
        Route::put('dps/{id}', 'Microcredit\Dps\Dps@update');
        Route::delete('dps/{id}', 'Microcredit\Dps\Dps@destroy');

        //fixedDeposit
        Route::get('fixedDeposit', 'Microcredit\FixedDeposit\FixedDeposit@index');
        Route::get('fixedDeposit/{id}', 'Microcredit\FixedDeposit\FixedDeposit@show');
        Route::post('fixedDeposit', 'Microcredit\FixedDeposit\FixedDeposit@store');
        Route::put('fixedDeposit/{id}', 'Microcredit\FixedDeposit\FixedDeposit@update');
        Route::delete('fixedDeposit/{id}', 'Microcredit\FixedDeposit\FixedDeposit@destroy');

        //Grantors
        Route::get('grantor', 'Microcredit\Grantors\Grantor@index');
        Route::get('grantor/{id}', 'Microcredit\Grantors\Grantor@show');
        Route::post('grantor', 'Microcredit\Grantors\Grantor@store');
        Route::put('grantor/{id}', 'Microcredit\Grantors\Grantor@update');
        Route::delete('grantor/{id}', 'Microcredit\Grantors\Grantor@destroy');


        //nominee
        Route::get('nominee', 'Microcredit\Nominee\Nominee@index');
        Route::get('nominee/{id}', 'Microcredit\Nominee\Nominee@show');
        Route::post('nominee', 'Microcredit\Nominee\Nominee@store');
        Route::put('nominee/{id}', 'Microcredit\Nominee\Nominee@update');
        Route::delete('nominee/{id}', 'Microcredit\Nominee\Nominee@destroy');


        //nominee
        Route::get('employee', 'Employees\Employee@index');
        Route::get('employee/{id}', 'Employees\Employee@show');
        Route::post('employee', 'Employees\Employee@store');
        Route::put('employee/{id}', 'Employees\Employee@update');
        Route::delete('employee/{id}', 'Employees\Employee@destroy');

        //microcredit transactions
        Route::get('transaction-microcredit', 'Microcredit\TranscationMicrocredit\TransactionMicrocredit@index');
        Route::post('transaction-microcredit/instalment/{type}', 'Microcredit\TranscationMicrocredit\TransactionMicrocredit@store');
        Route::get('transaction-microcredit/instalment', 'Microcredit\TranscationMicrocredit\TransactionMicrocredit@getInstalment');
        Route::put('transaction-microcredit/instalment/{id}', 'Microcredit\TranscationMicrocredit\TransactionMicrocredit@editInstalment');
        Route::get('transaction-microcredit/instalment/{id}', 'Microcredit\TranscationMicrocredit\TransactionMicrocredit@show');

    });
});

        

  