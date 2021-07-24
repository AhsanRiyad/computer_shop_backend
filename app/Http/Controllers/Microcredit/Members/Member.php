<?php

namespace App\Http\Controllers\Microcredit\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Microcredit\Members\Member as B;
use App\Models\Microcredit\Nominee\Nominee;
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

        // return B::with(['created_by'])->paginate(10);
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
        $member = B::create($request->member);
        $member->nominee()->associate(Nominee::create($request->nominee));
       
        return $member->refresh();
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
        // if (B::where('id', $id)->update($request->all())) {
        //     return new BR(B::find($id));
        // };
        // abort(403, 'Not found');
        $member = B::find($id);
        if(isset($member)){
            $member->update($request->member);
            // return $member->nominee;
            if (isset($member->nominee)) {
                $member->nominee()->update($request->nominee);
            } else {
                $member->nominee()->associate(Nominee::create($request->nominee));
                $member->save();
            }
            return $member->refresh();
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
