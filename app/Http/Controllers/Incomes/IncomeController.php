<?php

namespace App\Http\Controllers\Incomes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incomes\Income as B;
use App\Http\Resources\Incomes\Income as BR;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIncomeName(Request $req)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIncomeName(Request $request)
    {
        B::create($request->all());
        return new BR($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showIncomeName($id)
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
    public function updateIncomeName(Request $request, $id)
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
    public function destroyIncomeName($id)
    {
        //
        $menu = B::find($id);
        if (B::destroy($id)) {
            return new BR($menu);
        }
        abort(403, 'Not found');
    }
}
