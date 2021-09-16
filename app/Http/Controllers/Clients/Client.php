<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Models\Branches\Branch;
use App\Http\Others\SampleEmpty;
use App\Models\Clients\Client as C;
use App\Http\Controllers\Controller;

use App\Http\Resources\Clients\Client as CR;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name . ' Type: ' . $this->type,
            'id' => $this->id
        ];
    }
}

class Client extends Controller
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
        return $branch_id;
        if (
            $req->q == ''
        ) {
            return CR::collection(C::with(['created_by'])->whereHas('branch', function ($q) use ($branch_id) {
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
        //
        $branch =  auth()->user()->branch;
        $count =  C::where('name', $request->name)->whereHas('branch', function ($q) use ($branch) {
            $q->where('branch_id', $branch->id);
        })->count();

        if ($count == 0) {
            return $branch->clients()->create($request->all());
        } else {
            return response('already exists', 403);
        }

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
    }
    public function getAllSeller(Request $req)
    {
        //
        // return CR::collection(C::where('type', '=', 'seller')->with(['created_by'])->paginate(10));

        //
        $branch_id =  auth()->user()->branch_id;
        // return $branch_id;
        if (
            $req->q == ''
        ) {
            return CR::collection(C::where('type', 'seller')->with(['created_by'])->whereHas('branch', function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            })->paginate(10));
        } else {
            return $this->search($req, 'seller');
        }
    }

    public function getAllCustomer(Request $req)
    {
        //
        $branch_id =  auth()->user()->branch_id;
        // return $branch_id;
        if (
            $req->q == ''
        ) {
            return CR::collection(C::where('type' , 'customer')->with(['created_by'])->whereHas('branch', function ($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            })->paginate(10));
        } else {
            return $this->search($req , 'customer');
        }

    }

    public function index_seller()
    {
        //
        $branch_id =  auth()->user()->branch_id;
        return CR::collection(C::where('branch_id', $branch_id)->where('type' , 'seller')->get(['name' , 'id']));
    }

    public function index_customer()
    {
        //
        $branch_id =  auth()->user()->branch_id;
        return CR::collection(C::where('branch_id', $branch_id)->where('type', 'cust')->get(['name', 'id']));
    }

    public function index_client()
    {
        //
        return ClientResource::collection(C::all());
    }

    public function search(Request $req , $type)
    {
        $branch_id = auth()->user()->branch_id;
        // $req['type'] = $type;
        
        $a =  CR::collection(C::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', $branch_id);
        })->where('type', $type)->where(function ($q) use ($req) {
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
        foreach ($request->all() as $value) {
            C::Create($value);
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
