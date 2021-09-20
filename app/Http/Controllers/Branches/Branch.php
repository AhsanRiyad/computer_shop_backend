<?php

namespace App\Http\Controllers\Branches;

use DB;
use Illuminate\Http\Request;
use App\Models\Clients\Client;
use App\Http\Others\SampleEmpty;
use App\Http\Controllers\Controller;
use App\Models\Branches\Branch as B;
use App\Http\Resources\Branches\Branch as BR;

class Branch extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $shop_id =  auth()->user()->shop_id;
        if ($req->q == '') {
            return BR::collection(B::where('shop_id' , $shop_id )->with(['created_by'])->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = B::where('shop_id' , auth()->user()->id)->where('name' , $request->name)->count();
        if($count == 0){
            $branch =  B::create($request->all());
            $branch->clients()->createMany([
                ['name' => 'Walk in seller', 'type' => 'seller'],
                ['name' => 'Walk in customer', 'type' => 'customer']
            ]); 
            return new BR($request->all());
        }else{
            abort(403);
        }
    }

    public function product(Request $req)
    {
        //
        return B::with(['products'])->get();
    }

    public function dropdown()
    {
        //
        $shop_id =  auth()->user()->shop_id;
        return BR::collection(B::where('shop_id', $shop_id)->get(['name', 'id']));
        // return BR::collection(B::get(['name', 'id']));
    }


    public function search(Request $req)
    {
        $shop_id = auth()->user()->shop_id;
        $a =  BR::collection(B::where('shop_id' , $shop_id)->where(function ($q) use ($req) {
            return $q->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%');
        })->orderBy('id', 'desc')->paginate(10));

        if ($a->count() > 0) return $a;
        else return  json_encode(new SampleEmpty([]));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return new BR(B::find($id));
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
        if (B::where('id', $id)->update($request->all())) {
            return new BR(B::find($id));
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
        $menu = B::find($id);
        if (B::destroy($id)) {
            return new BR($menu);
        }
        abort(403, 'Not found');
    }
}
