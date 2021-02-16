<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reports\Report as R;
use App\Models\Orders\Order;



class Report extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function daily_sales(Request $req){
        // return 'ok';

        // ?date=
        //?fromDate=11&toDate=111
        // daily_sales?fromDate=2021-2-15&toDate=2021-4-2
        $date = date('y-m-d');
        $fromDate = '';
        $toDate = '';
        if( $req->fromDate != '') {
            $fromDate = $req->fromDate;
            $toDate = $req->toDate;

            $Purchase =  Order::whereDate('date' ,'>=' ,$fromDate)->whereDate('date' ,'<=' ,$toDate)->where('type' , 'purchase')->get();
            $Sell =  Order::whereDate('date' ,'>=' ,$fromDate)->whereDate('date' ,'<=' ,$toDate)->where('type' , 'sell')->get();
        }else{
            $Purchase =  Order::whereDate('date' ,'=' ,$date)->where('type' , 'purchase')->get();
            $Sell =  Order::whereDate('date' ,'=' ,$date)->where('type' , 'sell')->get();
        }

        if( $req->date != '') {
            $date = $req->date;
        }

        $subtotalPurchase = 0;
        $totalDiscountPurchase = 0;
        $subtotalSell = 0;
        $totalDiscountSell = 0;

        foreach( $Purchase as $O ){
            $subtotalPurchase +=  $O->getTotal();
            $totalDiscountPurchase +=  $O->discounts();
        }

        foreach( $Sell as $O ){
            $subtotalSell +=  $O->getTotal();
            $totalDiscountSell +=  $O->discounts();
        }

        return [
         'subtotalPurchase' => sprintf( "%.2f" , $subtotalPurchase ),
         'totalDiscountPurchase' => sprintf( "%.2f" , $totalDiscountPurchase ), 
         'totalPurchase' =>  sprintf( "%.2f" , ($subtotalPurchase - $totalDiscountPurchase) ),
         'subtotalSell' => sprintf( "%.2f" , $subtotalSell ),
         'totalDiscountSell' => sprintf( "%.2f" , $totalDiscountSell ), 
         'totalSell' =>  sprintf( "%.2f" , ($subtotalSell - $totalDiscountSell) ),
         ];
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
