<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Order as O;
use App\Http\Requests\Orders\Order as OV;
use App\Models\Products\Serial_number;
use App\Models\Clients\Client;
use App\Models\Products\Serial_sell;
use App\Models\Products\Product;
use App\Models\Products\Serial_purchase;
use App\Http\Resources\Orders\Order as R;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Products\ProductResource;

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
        //  return $req->page;
        //  
        //  $menu = O::find(2);
        //  return $menu->serial_numbers; 
        //  return $menu->products; 
        //  return $menu->order_details; 
        //  return $menu;

        if ($req->q == '') {
            /*
            return R::collection( O::with(['address', 'client' , 'order_details'])->get() );*/
            $order_info = [];
            // return O::find(1)->getTotal();

            $orders = O::with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell'])->where('type', '=', 0)->orderBy('id', 'desc')->paginate(10);

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
                $order['discountInteger'] = $order->discount;
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
            $order_info['meta']['from'] =  isset($req->page) && $req->page > 0 ? $req->page * 10 : 0 ;
            $order_info['meta']['to'] =  isset($req->page) && $req->page > 0 ? 10 : ($req->page * 10)+10 ;
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
            })->orWhere('id_customized', 'like', '%' . $req->q . '%')->count(); 
        */

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

        $orders = $searchResults->with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell'])->orderBy('id', 'desc')->paginate(10);

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
        //  return $menu;

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

            $orders = O::with(['address', 'client', 'created_by', 'updated_by', 'order_details', 'warranty', 'transactions', 'order_return', 'serial_numbers_purchase.order_detail', 'serial_numbers_sell.order_detail'])->where('type', '=', 1)->paginate(10);

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
                $order['discountInteger'] = $order->discount;
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

 
    public function orderReqiredData(){
        // return 'this is the required data';
        // return Product::get([
        //     'name', 'id', 'price', 'cost', 'having_serial'
        // ]);
        $products =
        ProductResource::collection(Product::get([
            'name', 'id', 'price', 'cost', 'having_serial'
        ]));

        $collection = collect($products);

        $filtered = $collection->filter(function ($value, $key) {
            return $value['inStock'] > 0;
        });

        $filteredProducts = [];
        $products =  $filtered->all();

        foreach ($products as $p) {
            if ($p['inStock'] > 0) {
                $filteredProducts[] = $p;
            }
        }
        return $filteredProducts;
    }

    public function test(Request $request){
        // $s = Serial_number::first();
        // return $s;
        $purchase = [];
        $sell = [];
        // $serial =  Serial_number::first();
        // return $serial->order_detail->order->type;
        Serial_number::chunk(200, function ($numbers) use (&$purchase, &$sell) {
            foreach ($numbers as $number) {
                
                if($number->order_detail->order->type == 0 && $number->order_detail->order->branch_id == 1  ){
                    $purchase[] = [ 'number' => $number->number, 'product_id' => $number->order_detail->product_id ];
                }else if($number->order_detail->order->type == 1 && $number->order_detail->order->branch_id == 1){
                    $sell[] = [ 'number' => $number->number, 'product_id' => $number->order_detail->product_id ];
                }
            }
        });
        return ['purchase' => $purchase , 'sell' => $purchase ];
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
  
    public function store(OV $request)
    {

        // return $request;
        // return 'storing orders';

        // hint 1
        // if( $request->mobile != '' && $request->contact_person != '' && $request->address != ''){
        //     return 'save';
        // }

        // hint 2
        // return $request->products[0]['quantity'];

        // hint 3
        // return $request->products[0]['serials'];

        // $order =  O::create([
        //     'date' => $request->date,
        //     'type' => $request->type,
        //     'discount' => $request->discount,
        //     'reference' => $request->reference,
        //     'correction_status' => $request->correction_status,
        //     'client_id' => $request->client_id,
        //     'branch_id' => $request->branch_id,
        // ]);

        // return $request->address;

        DB::beginTransaction();
        try {
            $order =  O::create($request->order);
            if (  isset($request->address['name']) ||  isset($request->address['mobile']) ||  isset($request->address['address'])) {
                $order->address()->create($request->address);
            }
            foreach (collect($request->order_detail) as $product) {
                # code...
                // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $order_detail =  $order->order_details()->create($o);
                // $s = collect($product)->only(['serials'])->all();

                if(isset($product['serials'])){
                    foreach ($product['serials'] as $p) {
                        # code...
                        $order_detail->serial_numbers()->create(['number' => $p]);
                    }
                }

                // $order_detail->serial_numbers()->createMany([['number' => 123]]);
                // $serials[] = collect($product)->only(['serials'])->all();
            }
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 403);
            // something went wrong
        }
        // foreach ($request->products as $value) {
        //      return $value;
        // }

        // return 'ok';
    } 

    public function update(Request $request, $id)
    {

        // return $request;

        DB::beginTransaction();
        try {
            //code...
            $order = O::find($id);

            $order->address()->delete();
            if (isset($request->address['name']) ||  isset($request->address['mobile']) ||  isset($request->address['address'])) {
                $order->address()->create($request->address);
            }
            // $order->serial_numbers()->delete();

            $order->update($request->order);
            $order->order_details()->delete();

            foreach (collect($request->order_detail) as $product) {
                # code...
                // $order_detail[] = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $o = collect($product)->only(['product_id', 'quantity', 'price'])->all();
                $order_detail =  $order->order_details()->updateOrCreate(["product_id" => $o['product_id']], $o);
                // $serials = collect($product)->only(['serials'])->all();

                // foreach ($product['serials'] as $p) {
                //     # code...
                //     $order_detail->serial_numbers()->create(['number' => $p]);
                // }

                // $order_detail->serial_numbers()->createMany($s['serials']);

                // $serials[] = collect($product)->only(['serials'])->all();
            }
            $order->refresh();
            $order->updated_by = Auth::id();
            $order->date = $request->order['date'];
            $order->save();
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollback();
            return response($e, 403);
        }
        // return $id;
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
                // delete all serial number related to the order
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
    public function printInvoice( $order_id)
    {
        //
        $order['order_info'] = O::find($order_id);
        // return $order;
        $pdf = PDF::loadView('invoice.invoice' , $order );
        // $pdf->save('storage/users_info.pdf');
        return $pdf->stream('users_info.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printInvoiceByInfo(Request $request)
    {
        //
        // return $request->all()['order']['client_id'];
        // return $request->all();
        $order_info =  $request->all()['order'];
        $order_detail =  $request->all()['order_detail'];
        $address = $request->all()['address'];
        $client = Client::find($request->all()['order']['client_id']);
        
        // return compact('order_info', 'order_detail', 'address', 'client');

        $pdf = PDF::loadView('invoice.invoiceByInfo', compact('order_info' , 'order_detail' , 'address', 'client'));
        // $pdf->save('storage/users_info.pdf');
        return $pdf->stream('users_info.pdf');
        // return $request->all()['order'];

        // $order['order_info'] = O::find($order_id);
        // return $order;
        // $pdf = PDF::loadView('invoice.invoice' , $order );
        // $pdf->save('storage/users_info.pdf');
        // return $pdf->stream('users_info.pdf');
    }



}
