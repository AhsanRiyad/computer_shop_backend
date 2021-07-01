<?php

namespace App\Http\Controllers\Microcredit\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Others\SampleEmpty;
use App\Models\Microcredit\Members\Member as B;
use App\Http\Resources\Microcredit\Members\Member as BR;
use DB;


class Member extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        if ($req->q == '') {
            return BR::collection(B::with(['created_by'])->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    public function dropdown()
    {
        //
        return BR::collection(B::get(['name', 'id']));
    }

    public function search(Request $req)
    {
        // return $req->search;

        if (B::where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->count() > 0) {
            return BR::collection(B::with(['created_by'])->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->paginate(10));
        } else {
            return  json_encode(new SampleEmpty([]));
        };

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        B::create($request->all());
        return new BR($request->all());

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
