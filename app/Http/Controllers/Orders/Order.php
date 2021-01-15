<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Order as O;
use App\Http\Requests\Orders\Order as OV;
use App\Models\Products\Serial_number as S;
use App\Models\Products\Serial_sell;
use App\Models\Products\Serial_purchase;
use App\Http\Resources\Orders\Order as R;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Auth;

class SampleEmpty
{
    // Properties
    public  $data;
    function __construct($data)
    {
        // $this->data = $data;
        $this->data =  [  'order' => [] , 'meta' => [ 'total' => 0 ]  ];
    }
    // Methods
    /*  function set_name($name)
    {
        $this->name = $name;
    }
    function get_name()
    {
        return $this->name;
    } */
}

class Order extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        // return $req->page;
        //
        //  $menu = O::find(2);
        //  return $menu->serial_numbers; 
        //  return $menu->products; 
        //  return $menu->order_details; 
        // return $menu;

        if ($req->q == '') {
            /*
        return R::collection( O::with(['address', 'client' , 'order_details'])->get() );*/
            $order_info = [];
            // return O::find(1)->getTotal();

            $orders = O::with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell'])->where('type', '=', 'purchase')->orderBy('id', 'desc')->paginate(10);

            // $a = R::collection($orders);
            // var_dump($a);
            // return $orders['total'];
            // return R::collection($orders);
            // dd(R::collection($orders));
            // $order_info['meta'] = R::collection($orders)['meta'];
            foreach ($orders as $order) {
                $order['id_customized'] = 'HCC-' . $order->id_customized;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount();
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                // $order['date'] = date('d-m-Y', strtotime($order->date));
                $order['received'] = $order->received();
                $order['created'] = $order->created_by();
                $order['updated'] = $order->updated_by();


                $order_info['order'][] = $order;
            }
            $order_info['meta']['total'] = O::where('type', '=', 'purchase')->count();
            return R::collection(collect($order_info)->reverse());
        } else {
            return $this->searchPurchase($req);
        }
        
        // $b['meta'] = 10;
        // return $b;
        /* O::with(['address', 'client' , 'created_by', 'updated_by' ,'order_details', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell' ])->where('type', '=' ,'purchase')->chunk( 200 , function($result) use (&$order_info){
            
            foreach ($result as $order) {
                # code...

                $order['id_customized'] =  'HCC-' . $order->id;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount() ;
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();
                $order['created'] = $order->created_by();
                $order['updated'] = $order->updated_by();
                

                $order_info[] = $order;
            }

        });
        return R::collection( collect($order_info)->reverse()); */
    }

    public function searchPurchase(Request $req)
    {
        // return $req->search;

        $searchResultsByClient =  O::where([['type', '=', 'purchase']])->whereHas('client', function ($query) use (&$req) {
            return $query->where([['name', 'like', '%' . $req->q . '%'],]);
        });

        $searchResultsById =  O::where([['type', '=', 'purchase'], ['id_customized', 'like', '%' . $req->q . '%']]);

        if ($searchResultsById->count() > 0) {
            return $this->searchResultsPurchase($searchResultsById);
        } else if ($searchResultsByClient->count() > 0) {
            return $this->searchResultsPurchase($searchResultsByClient);
        } else {
            return  json_encode(new SampleEmpty([]));
        };
/* 
        return O::whereHas('client', function ($query) use (&$req) {
            return $query->where('name','like', '%' . $req->q . '%');
        })->orWhere('id_customized', 'like', '%' . $req->q . '%')->count(); */

/* 
        return O::with(['client' => function($q)  use (&$req){
            $q->where('name' ,'like', '%' . 'noora' . '%');
        }])->paginate(10); */


        // return $req->q;
    }

    public function searchSell(Request $req)
    {
        // return $req->search;

        $searchResultsByClient =  O::where([['type' , '=' , 'sell']])->whereHas('client', function ($query) use (&$req) {
            return $query->where([['name', 'like', '%' . $req->q . '%'],]);
        });

        $searchResultsById =  O::where([['type' , '=' , 'sell'], ['id_customized', 'like', '%' . $req->q . '%']]);

        if($searchResultsById->count() > 0){
            return $this->searchResultsSell($searchResultsById);
        }
        else if ($searchResultsByClient->count() > 0) {
            return $this->searchResultsSell($searchResultsByClient);
        } else {
            return  json_encode(new SampleEmpty([]));
        };
        /* 
        return O::whereHas('client', function ($query) use (&$req) {
            return $query->where('name','like', '%' . $req->q . '%');
        })->orWhere('id_customized', 'like', '%' . $req->q . '%')->count(); */

        /* 
        return O::with(['client' => function($q)  use (&$req){
            $q->where('name' ,'like', '%' . 'noora' . '%');
        }])->paginate(10); */

        // return $req->q;
    }

    public function searchResultsPurchase($searchResults){
        $order_info = [];
        // return O::find(1)->getTotal();

        $orders = $searchResults->with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell'])->orderBy('id', 'desc')->paginate(10);

        // $a = R::collection($orders);
        // var_dump($a);
        // return $orders['total'];
        // return R::collection($orders);
        // dd(R::collection($orders));
        // $order_info['meta'] = R::collection($orders)['meta'];
        foreach ($orders as $order) {
            $order['id_customized'] = 'HCC-' . $order->id_customized;
            $order['total'] = $order->getTotal();
            $order['balance'] = $order->balance();
            $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount();
            $order['subtotal'] = $order->getSubTotal();
            $order['paid'] = $order->paid();
            $order['received'] = $order->received();
            $order['created'] = $order->created_by();
            $order['updated'] = $order->updated_by();

            $order_info['order'][] = $order;
        }
        $order_info['meta']['total'] = $searchResults->count();
        return R::collection(collect($order_info)->reverse());
        // $b['meta'] = 10;
        // return $b;
        /* O::with(['address', 'client' , 'created_by', 'updated_by' ,'order_details', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell' ])->where('type', '=' ,'purchase')->chunk( 200 , function($result) use (&$order_info){
            
            foreach ($result as $order) {
                # code...

                $order['id_customized'] =  'HCC-' . $order->id;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount() ;
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();
                $order['created'] = $order->created_by();
                $order['updated'] = $order->updated_by();
                

                $order_info[] = $order;
            }

        });
        return R::collection( collect($order_info)->reverse()); */
    }

    public function searchResultsSell($searchResults){
        $order_info = [];
        // return O::find(1)->getTotal();

        $orders = $searchResults->with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_sell.order_detail', 'serial_numbers_purchase'])->orderBy('id', 'desc')->paginate(10);

        // $a = R::collection($orders);
        // var_dump($a);
        // return $orders['total'];
        // return R::collection($orders);
        // dd(R::collection($orders));
        // $order_info['meta'] = R::collection($orders)['meta'];
        foreach ($orders as $order) {
            $order['id_customized'] = 'HCC-' . $order->id_customized;
            $order['total'] = $order->getTotal();
            $order['balance'] = $order->balance();
            $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount();
            $order['subtotal'] = $order->getSubTotal();
            $order['paid'] = $order->paid();
            $order['received'] = $order->received();
            $order['created'] = $order->created_by();
            $order['updated'] = $order->updated_by();

            $order_info['order'][] = $order;
        }
        $order_info['meta']['total'] = $searchResults->count();
        return R::collection(collect($order_info)->reverse());
        // $b['meta'] = 10;
        // return $b;
        /* O::with(['address', 'client' , 'created_by', 'updated_by' ,'order_details', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell' ])->where('type', '=' ,'purchase')->chunk( 200 , function($result) use (&$order_info){
            
            foreach ($result as $order) {
                # code...

                $order['id_customized'] =  'HCC-' . $order->id;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount() ;
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();
                $order['created'] = $order->created_by();
                $order['updated'] = $order->updated_by();
                

                $order_info[] = $order;
            }

        });
        return R::collection( collect($order_info)->reverse()); */
    }


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_sell(Request $req)
    {
        //

        //  $menu = O::find(2);
        //  return $menu->serial_numbers; 
        //  return $menu->products; 
        //  return $menu->order_details; 
        // return $menu;

        /*
        return R::collection( O::with(['address', 'client' , 'order_details'])->get() );*/
        // $order_info= [];
        // return O::find(1)->getTotal();
        /* 
        O::with(['address', 'client' , 'created_by' , 'updated_by' ,'order_details', 'created_by', 'warranty' , 'transactions', 'order_return', 'serial_numbers_purchase', 'serial_numbers_sell.order_detail' ])->where('type', '=' ,'sell')->chunk( 200 , function($result) use (&$order_info){
            
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
        return R::collection( collect($order_info)->reverse()); */

        if ($req->q == ''
        ) {
            $order_info = [];
            // return O::find(1)->getTotal();

            $orders = O::with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell.order_detail'])->where('type', '=', 'sell')->paginate(10);

            // $a = R::collection($orders);
            // var_dump($a);
            // return $orders['total'];
            // return R::collection($orders);
            // dd(R::collection($orders));
            // $order_info['meta'] = R::collection($orders)['meta'];
            foreach ($orders as $order) {
                $order['id_customized'] = 'HCC-' . $order->id_customized;
                $order['total'] = $order->getTotal();
                $order['balance'] = $order->balance();
                $order['discount'] = $order->getDiscount() == "" ? 0 : $order->getDiscount();
                $order['subtotal'] = $order->getSubTotal();
                $order['paid'] = $order->paid();
                $order['received'] = $order->received();
                $order['created'] = $order->created_by();
                $order['updated'] = $order->updated_by();


                $order_info['order'][] = $order;
            }
            $order_info['meta']['total'] = O::where('type', '=', 'sell')->count();
            return R::collection(collect($order_info)->reverse());
        } else {
            return $this->searchSell($req);
        }


        
        
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

        DB::beginTransaction();

        try {
            $s = Serial_purchase::whereIn('number', $request->serials)->get();
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

            $order->refresh();
            $order->created_by = Auth::id();;
            $order->id_customized = date('Y') . (1000000000 + $order->id);
            $order->save();
            // return $order_detail;
            DB::commit();

            // $order->id_customized = ''
            return $order;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return response($e , 403);
            // something went wrong
        }

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
        // check if serials already used
        // return $request->order;
        
        // return $request;
        // $s = S::whereIn('number', $request->serials)->get();
        // if (count($s) > 0) return response( $s , 403 );
        
        DB::beginTransaction();

        try {
            

           $s = Serial_sell::whereIn('number', $request->serials)->get();
            if (count($s) > 0) return response( $s , 403 );
            
            $order = O::create($request->order);
            $order->address()->delete();
            $address = $order->address()->create( $request->address);
            // $address = O::create($request->address);
            foreach (collect($request->order_detail) as $product) {
                # code...
                // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $order_detail =  $order->order_details()->create($o);
                $s = collect($product)->only(['serials'])->all();
                $order_detail->serial_numbers_sell()->createMany($s['serials']);
                // $serials[] = collect($product)->only(['serials'])->all();
            }
            // return $order_detail;
            $order->refresh();
            $order->created_by = Auth::id();
            $order->id_customized = date('Y') . (1000000000 + $order->id);
            $order->save();
            DB::commit();
            return $order;
            // all good
        } catch (\Exception $e) {
            response($e , 403);
            DB::rollback();
            // something went wrong
        }


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
        DB::beginTransaction();

        try {

            $order = O::find($id);
            //delete all serial number related to the order
            // $order->serial_numbers()->delete();
            // return 0;
            $order->address()->delete();
            $address = $order->address()->create( $request->address);
            /* collect($order->order_detail)->each( function( $item , $key ){
                $item->serial_numbers()->delete();
            }); */
            $order->serial_numbers_purchase()->delete();
            // return $request->order;
            $order->update($request->order );
            $order->order_details()->delete();

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
            $order->refresh();
            $order->updated_by = Auth::id();
            $order->save();
            DB::commit();
            return $order; 


            // all good
        } catch (\Exception $e) {
            response($e , 403);
            DB::rollback();
            // something went wrong
        }






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


        DB::beginTransaction();

        try {


                    // return $request;
                $order = O::find($id);
                //delete all serial number related to the order
                // $order->serial_numbers()->delete();
                // return 0;
                $order->address()->delete();
                $address = $order->address()->create( $request->address);
                /* collect($order->order_detail)->each( function( $item , $key ){
                    $item->serial_numbers()->delete();
                }); */
                $order->serial_numbers_sell()->delete();
                $order->update($request->order );
                $order->order_details()->delete();

                foreach (collect($request->order_detail) as $product) {
                    # code...
                    // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                    $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                    $order_detail =  $order->order_details()->updateOrCreate( [ "product_id"=> $o['product_id'] ], $o);
                    $serials = collect($product)->only(['serials'])->all();

                    foreach ( $serials['serials'] as $s ) {
                        # code...
                        $order_detail->serial_numbers_sell()->updateOrCreate([ "number" => $s["number"] ], $s);
                    }

                    // $order_detail->serial_numbers()->createMany($s['serials']);

                    // $serials[] = collect($product)->only(['serials'])->all();
                }
                // return $order_detail;
                $order->refresh();
                $order->updated_by = Auth::id();
                $order->save();
                DB::commit();
                return $order; 


            // all good
        } catch (\Exception $e) {
            response($e , 403);
            DB::rollback();
            // something went wrong
        }






        

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
        // $pdf->save('storage/users_info.pdf');
        return $pdf->stream('users_info.pdf');
    }



}
