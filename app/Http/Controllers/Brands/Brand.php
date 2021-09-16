<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brands\Brand as B;
use App\Http\Resources\Brands\Brand as BR;
use DB;
use App\Http\Others\SampleEmpty;
use App\User;

class Brand extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $branch_id =  auth()->user()->branch_id;
        if ($req->q == '') {
            return BR::collection(B::with(['created_by'])->whereHas('branch' , function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            } )->paginate(10));
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
        //
        $branch =  auth()->user()->branch;
        $count =  B::where('name', $request->name)->whereHas('branch', function ($q) use ($branch) {
            $q->where('branch_id', $branch->id);
        })->count();

        if ($count == 0) {
            return $branch->brands()->create($request->all());
        } else {
            abort(403);
        }


        // B::create($request->all());
        // return new BR($request->all());

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
    }

    public function dropdown()
    {
        //
        $branch_id =  auth()->user()->branch_id;
        return BR::collection(B::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', $branch_id);
        })->get(['name', 'id']));
        // return BR::collection(B::get(['name', 'id']));
    }

    public function search(Request $req)
    {
        // return $req->search;
        $branch_id = auth()->user()->branch_id;
        $a =  BR::collection(B::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', $branch_id);
        })->where(function ($q) use ($req) {
            return $q->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%');
        })
        ->orderBy('id', 'desc')->paginate(10));

        if ($a->count() > 0) return $a;
        else return  json_encode(new SampleEmpty([]));

        // return $req->q;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        DB::table('brands')->insert(
            $request->all()
        );
        return $request;

        /*foreach ($request->all() as $value) {
            B::Create($value);
        }*/
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
        //
        // C::where('id' , $id)->update($request->all()));
        // return B::find($id);

        if ( B::where('id' , $id)->update( $request->all() ) )  {
            return new BR( B::find($id) );
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
