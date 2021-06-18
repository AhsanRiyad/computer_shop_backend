<?php


namespace App\Http\Controllers\Products;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Products\Product as C;

use App\Models\Products\Serial_number as S;

use App\Models\Products\Serial_purchase;

use App\Models\Products\Serial_sell;

use App\Http\Resources\Products\Product as CR;


use Illuminate\Http\Resources\Json\JsonResource;

use DB;

use App\Http\Others\SampleEmpty;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $client =  parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'inStock' => $this->inStock(),
            'quantity' => 1,
            'having_serial' => $this->having_serial,
        ];
    }
}
//

class Serial_numberIn extends JsonResource
{

    /**

     * Transform the resource into an array.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return array

     */

    public function toArray($request)

    {

        return [

            'id' => $this->id,

            'isNew' => false,

            'number' => $this->number,

            'product_id' =>  $this->order_detail['product_id'],

            'status' => 'Purchase'

        ];

    }

}

class Product extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $req)
    {
        //
        // return response( CR::collection(C::all()) ) ;
        /*$products = C::with(['brand', 'category', 'created_by'])->get();*/
        // return CR::collection(C::with(['brand', 'category', 'created_by', 'order_detail'])->paginate(10));

        if ($req->q == ''
        ) {
            return CR::collection(C::with(['brand', 'category', 'created_by'])->orderBy('id', 'desc')->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    public function dropdown()
    {
        //

        // return response( CR::collection(C::all()) ) ;

        /*$products = C::with(['brand', 'category', 'created_by'])->get();*/

        // return CR::collection(C::with(['brand', 'category', 'created_by', 'order_detail'])->paginate(10));
        return ProductResource::collection(C::get(['name' , 'id', 'price' , 'cost', 'having_serial']));

    }


    public function search(Request $req)
    {
        // return $req->search;

        if (C::where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->count() > 0) {
            return CR::collection(C::with(['created_by'])->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->paginate(10));
        } else {
            return  json_encode(new SampleEmpty([]));
        };

        // return $req->q;
    }


    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index_product_n_serial()

    {

        //

        // return response( CR::collection(C::all()) ) ;

        /*$products = C::with(['brand', 'category', 'created_by'])->get();*/

        // return 'ok';

        // $products =  CR::collection(C::with(['brand', 'category', 'created_by'])->get());
        $products = ProductResource::collection(C::get([  'name', 'id', 'price', 'cost', 'having_serial'
            ]));


        $collection = collect($products);

        $filtered = $collection->filter(function ($value, $key) {
            return $value['inStock'] > 0;
        });

        $filteredProducts = [] ; 
        $products =  $filtered->all();

        foreach($products as $p ){
            if($p['inStock'] > 0){
                $filteredProducts [] = $p;
            }
        }

        // return $products;
        // $serials_sell = Serial_sell::all();
        // $serials_numbers_sell = collect($serials_sell)->pluck('number');
        // $serials_purchase = Serial_purchase::whereNotIn('number', $serials_numbers_sell )->get();

        $serials_purchase = Serial_purchase::whereNotIn('number', Serial_sell::select('number')->get() )->get();
        // return $serials_purchase;
        // return Serial_number::collection( $serials_purchase );

        return response(['products' => $filteredProducts , 'serials' => Serial_numberIn::collection( $serials_purchase )] , 200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

        //

        /*foreach ($request->all() as $value) {

            C::Create($value);

        }*/

        //bulk create

        /*DB::table('products')->insert(

            $request->all()

        );*/

        //bulk update

        foreach ($request->all() as $p) {
            # code...

            C::updateOrCreate( [ 'id' => $p['id'] ], $p);
        }
        return $request;

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
        // return $request;
        return C::create($request->all());

        // return 'ok';

        // return new CR($request->all());



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
        $product = C::find($id);
        if($product == ''){
            return [];
        }else{
            return new CR($product);
        }
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

        // $category =  C::find($id);

        // C::where('id' , $id)->update($request->all()));

        if ( C::where('id' , $id)->update( $request->all() ) )  {

            return new CR( C::find($id) );

        };

        abort(403, 'Not found');

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

        $menu = C::find($id);

        if (C::destroy($id)) {

            return new CR($menu);

        }

        abort(403, 'Not found');

    }

}

