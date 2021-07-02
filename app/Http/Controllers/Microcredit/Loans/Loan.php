<?php

namespace App\Http\Controllers\Microcredit\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Others\SampleEmpty;
use App\Models\Microcredit\Loans\Loan as B;
use App\Models\Microcredit\Grantors\Grantor;
use App\Http\Resources\Microcredit\Loans\Loan as BR;
use DB;


class Loan extends Controller
{
    //
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
        $loan = B::create($request->loan);
        $loan->grantor()->associate(Grantor::create($request->grantor));
        $loan->save();
        return $loan->refresh();
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
        $loan = B::find($id);
        if(isset($loan)){
            $loan->update($request->loan);
            // return $member->grantor;
            if (isset($loan->grantor)) {
                $loan->grantor()->update($request->grantor);
            } else {
                $loan->grantor()->associate(Grantor::create($request->grantor));
                $loan->save();
            }
            return $loan->refresh();
        }else{
            abort(403, 'Not found');
        }
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
