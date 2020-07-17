<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Orders as O;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return O::with(['serials', 'order_details', 'transactions', 'products'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        $order =  O::create($request->order);

        $order->order_details()->createMany($request->order_details);

        $order->isPurchase ?
            $order->serials_p()->createMany($request->serials) :
            $order->serials_s()->createMany($request->serials);
        return $order;

        // return $request;

        // $product->save($parameters);


        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
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
        $order = O::with(['serials', 'order_details', 'transactions'])->find($id);
        return $order;
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
        $order =  O::find($id);

        $order->order_details()->detach();

        $order->isPurchase ?
            $order->serials_p()->detach() :
            $order->serials_s()->detach();

        $order->order_details()->createMany($request->order_details);
        $order->serials_s()->createMany($request->serials);

        return $order;



        // $product =  O::find($id);
        // $product->save($request->all());
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
        return O::destroy($id);
    }
}
