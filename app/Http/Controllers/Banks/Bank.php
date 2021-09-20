<?php

namespace App\Http\Controllers\Banks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banks\Bank as B;
use App\Http\Resources\Banks\Bank as BR;
use DB;
use App\Http\Others\SampleEmpty;

class Bank extends Controller
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
        if ($req->q == ''
        ) {
            return BR::collection(B::with(['created_by'])->whereHas('branch', function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            })->paginate(10));
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
        $branch =  auth()->user()->branch;
        $count =  B::where('name', $request->name)->whereHas('branch', function ($q) use ($branch) {
            $q->where('branch_id', $branch->id);
        })->count();

        if ($count == 0) {
            return $branch->banks()->create($request->all());
        } else {
            abort(403);
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
