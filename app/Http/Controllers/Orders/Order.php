<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Order as O;
use App\Http\Requests\Orders\Order as OV;
use App\Models\Products\Serial_number as S;
use App\Http\Resources\Orders\Order as R;
use Illuminate\Support\Facades\DB;
use PDF;


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

        //  $menu = O::find(2);
        //  return $menu->serial_numbers; 
        //  return $menu->products; 
        //  return $menu->order_details; 
        // return $menu;
       
/*
        return R::collection( O::with(['address', 'client' , 'order_details'])->get() );*/
        $order_info= [];
        // return O::find(1)->getTotal();

        O::with(['address', 'client' , 'order_details', 'created_by', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase', 'serial_numbers_sell' ])->where('type', '=' ,'purchase')->chunk( 200 , function($result) use (&$order_info){
            
            foreach ($result as $order) {
                # code...

                $order['id_customized'] =  'HCC-' . $order->id;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount() ;
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();
                

                $order_info[] = $order;
            }

        });
        return R::collection( collect($order_info)->reverse());
    }
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_sell()
    {
        //

        //  $menu = O::find(2);
        //  return $menu->serial_numbers; 
        //  return $menu->products; 
        //  return $menu->order_details; 
        // return $menu;
       
/*
        return R::collection( O::with(['address', 'client' , 'order_details'])->get() );*/
        $order_info= [];
        // return O::find(1)->getTotal();

        O::with(['address', 'client' , 'order_details', 'created_by', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase', 'serial_numbers_sell' ])->where('type', '=' ,'sell')->chunk( 200 , function($result) use (&$order_info){
            
            foreach ($result as $order) {
                # code...

                $order['id_customized'] =  'HCC-' . $order->id;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance_sell();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount() ;
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();


                $order_info[] = $order;
            }

        });
        return R::collection( collect($order_info)->reverse());
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
        // return $request->order;
        
        // return $request;
        $s = S::whereIn('number', $request->serials)->get();
        if (count($s) > 0) return response( $s , 403 );
        
        $order = O::create($request->order);
        $address = $order->address()->create($request->address);
        // $address = O::create($request->address);
        foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_details()->create($o);
            $s = collect($product)->only(['serials'])->all();
            $order_detail->serial_numbers_purchase()->createMany($s['serials']);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_sell(OV $request)
    {
        //
        // C::create($request->all());
        // return new CR($request->all());
        // return new CR($request->order_detail);
        // $order = new O;
        // for updated
        // return $request->serials;
        //check if serials already used
        // return $request->order;
        
        // return $request;
        // $s = S::whereIn('number', $request->serials)->get();
        // if (count($s) > 0) return response( $s , 403 );
        
        $order = O::create($request->order);
        $address = $order->address()->create($request->address);
        // $address = O::create($request->address);
        foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_details()->create($o);
            $s = collect($product)->only(['serials'])->all();
            // $order_detail->serial_numbers_purchase()->createMany($s['serials']);

            // $order_detail->serial_numbers_sell()->sync($s);

            S::whereIn('id', $s)->update(['order_detail_sell_id' => $order_detail->id , 'status' => 'sell']);

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
        //delete all serial number related to the order
        // $order->serial_numbers()->delete();
        // return 0;
        $address = $order->address()->updateOrCreate( [ 'mobile' => $request->address['mobile'] ], $request->address);
        /* collect($order->order_detail)->each( function( $item , $key ){
            $item->serial_numbers()->delete();
        }); */
        $order->update($request->order );

         foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_details()->updateOrCreate( [ "product_id"=> $o['product_id'] ], $o);
            $serials = collect($product)->only(['serials'])->all();

            foreach ( $serials['serials'] as $s ) {
                # code...
                $order_detail->serial_numbers_purchase()->updateOrCreate([ "number" => $s["number"] ], $s);
            }

            // $order_detail->serial_numbers()->createMany($s['serials']);

            // $serials[] = collect($product)->only(['serials'])->all();
        }
        // return $order_detail;
        $order->refresh();
        return $order; 
    }



     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sell(OV $request, $id)
    {
        //
        // C::create($request->all());
        // return new CR($request->all());
        // return new CR($request->order_detail);
        // $order = new O;
        // for updated
        // return $request->serials;
        //check if serials already used
        // return $request->order;
        
        // return $request;
        // $s = S::whereIn('number', $request->serials)->get();
        // if (count($s) > 0) return response( $s , 403 );
        
        // return $request;

        $order = O::find($id);
        $order->update($request->order);
        $order->address()->update($request->address);

        $order->order_details()->delete();

        // $address = O::create($request->address);
        foreach (collect($request->order_detail) as $product) {
            # code...
            // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
            $order_detail =  $order->order_details()->create($o);
            $s = collect($product)->only(['serials'])->all();
            // $order_detail->serial_numbers_purchase()->createMany($s['serials']);

            // $order_detail->serial_numbers_sell()->sync($s);

            S::whereIn('id', $s)->update(['order_detail_sell_id' => $order_detail->id , 'status' => 'sell']);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printInvoice(Request $request, $order_id)
    {
        //
        $order['order_info'] = O::find($order_id);
        $pdf = PDF::loadView('invoice.invoice' , $order );
        $pdf->save('storage/users_info.pdf');
        return $pdf->stream('users_info.pdf');
    }



}
