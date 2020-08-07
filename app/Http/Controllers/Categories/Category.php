<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\Category as C;
use App\Http\Resources\Categories\Category as CR;
use Illuminate\Http\Response;
use PDF;
use DB;

class Category extends Controller
{

    public function test()
    {
        //
        // return CR::collection(C::with(['created_by'])->get());
        // $data['users_info'] = $req->users_info;
        $pdf = PDF::loadView('invoice.invoice' );
        $pdf->save('storage/users_info.pdf');
        return $pdf->stream('users_info.pdf');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CR::collection(C::with(['created_by'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        DB::table('categories')->insert(
            $request->all()
        );
        return $request;

        /*foreach ($request->all() as $value) {
            C::Create($value);
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
        C::create($request->all());
        return new CR($request->all());

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
        return new CR(C::find($id));
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
