<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Orders\Orders as O;

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
        return O::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_p(Request $request)
    {
        $order =  O::create($request->order);
        $order->order_details()->createMany($request->order_details);
        $order->serials_p()->createMany($request->serials);
        return $order;
    }

    public function create_s(Request $request)
    {
        $order =  O::create($request->order);
        $order->order_details()->createMany($request->order_details);
        $order->serials_s()->createMany($request->serials);
        return $order;
    }

    public function update_s(Request $request, $id)
    {
        $order =  O::find($id);

        $order->order_details()->detach();
        $order->serials_s()->detach();

        $order->order_details()->createMany($request->order_details);
        $order->serials_s()->createMany($request->serials);

        return $order;
    }

    public function update_p(Request $request, $id)
    {
        $order =  O::find($id);

        $order->order_details()->detach();
        $order->serials_p()->detach();

        $order->order_details()->createMany($request->order_details);
        $order->serials_p()->createMany($request->serials);

        return $order;
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
        return O::create($request->all());

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
        return O::find($id);
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
        $product =  O::find($id);
        $product->save($request->all());
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
        return O::destroy(1);
    }
}
