<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Order as O;
use App\Http\Requests\Orders\Order as OV;
use App\Models\Products\Serial_number as S;
use App\Http\Resources\Orders\Order as R;

class Order extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return R::collection(O::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        foreach ($request->all() as $value) {
            O::Create($value);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OV $request)
    {
        //
        // C::create($request->all());
        // return new CR($request->all());
        // return new CR($request->order_detail);
        // $order = new O;
        // for updated
        // return $request->serials;
        //check if serials already used
        $s = S::whereIn('number', $request->serials)->get();
        if ($s != []) return response( $s , 403 );

        $order = O::create($request->order);
        foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_detail()->create($o);
            $s = collect($product)->only(['serials'])->all();
            $order_detail->serial_numbers()->createMany($s['serials']);
            // $serials[] = collect($product)->only(['serials'])->all();
        }
        // return $order_detail;
        // $order->refresh();
        return $order;
        // return $s['serials'];

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
        return new R(O::find($id));
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
        $order = O::find($id);
        
        collect($order->order_detail)->each( function( $item , $key ){
            $item->serial_numbers()->delete();
        });

        /* foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_detail()->updateOrCreate( [ "product_id"=> $o['product_id'] ], $o);
            $s = collect($product)->only(['serials'])->all();
            $order_detail->serial_numbers()->createMany($s['serials']);
            // $serials[] = collect($product)->only(['serials'])->all();
        }
        // return $order_detail;
        $order->refresh();
        return $order; */
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
        $menu = O::find($id);
        if (O::destroy($id)) {
            return new R($menu);
        }
        abort(403, 'Not found');
    }
}
