<?php

namespace App\Http\Controllers\Microcredit\Members;

use DB;
use Illuminate\Http\Request;
use App\Http\Others\SampleEmpty;
use App\Http\Controllers\Controller;
use App\Models\Microcredit\Nominee\Nominee;
use App\Models\Microcredit\Members\Member as B;
use App\Http\Resources\Microcredit\Members\Member as BR;

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

        $branch_id =  auth()->user()->branch_id;
        // return $branch_id;
        if (
            $req->q == ''
        ) {
            return BR::collection(B::with(['created_by'])->whereHas('branch', function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            })->paginate(10));
        } else {
            return $this->search($req);
        }

    }

    public function dropdown()
    {
        //
        // return BR::collection(B::get(['name', 'id']));

        $branch_id =  auth()->user()->branch_id;
        // return BR::collection(B::where('branch_id', $branch_id)->get(['name', 'id']));
        return BR::collection(B::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', $branch_id);
        })->orderBy('id', 'desc')->get(['name', 'id']));
    }


    public function search(Request $req)
    {
        $branch_id = auth()->user()->branch_id;
        // $req['type'] = $type;

        $a =  BR::collection(B::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', $branch_id);
        })->where(function ($q) use ($req) {
            return $q->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%');
        })->orderBy('id', 'desc')->paginate(10));

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Nominee::create($request->nominee);
        // $member = B::create($request->member);
        // $member->nominee()->associate(Nominee::create($request->nominee));
        // $member->save();
        // return $member->refresh();
        // return $request->member['name'];
        $branch =  auth()->user()->branch;
        // return $branch;
        $count =  B::where('name', $request->member['name'])->whereHas('branch', function ($q) use ($branch) {
            $q->where('branch_id', $branch->id);
        })->count();
        if ($count == 0) {
            $member =  $branch->members()->create($request->member);
            $member->nominee()->associate(Nominee::create($request->nominee));
            $member->save();
            return $member->refresh();
        } else {
            return response('already exists', 403);
        }
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
        return new BR(B::with(['nominee'])->find($id));
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
