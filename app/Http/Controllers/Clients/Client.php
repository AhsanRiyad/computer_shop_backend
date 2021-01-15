<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients\Client as C;
use App\Http\Resources\Clients\Client as CR;
use App\Http\Others\SampleEmpty;

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
        if ($req->q == '') {
            return CR::collection(C::with(['created_by'])->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    public function index_seller()
    {
        //
        return CR::collection(C::where('type' , '=' , 'seller')->get(['name' , 'id']));
    }

    public function index_customer()
    {
        //
        return CR::collection(C::where('type' , '=' , 'customer')->get(['id' , 'name']));
    }

    public function index_client()
    {
        //
        return ClientResource::collection(C::all());
    }


    public function search(Request $req)
    {
        // return $req->search;
        if (C::where('id', 'like', '%' . $req->q . '%')->count() > 0) {
            return CR::collection(C::with(['created_by'])->where('id', 'like', '%' . $req->q . '%')->paginate(10));
        } else if (C::where('name', 'like', '%' . $req->q . '%')->count() > 0) {
            return CR::collection(C::with(['created_by'])->where('name', 'like', '%' . $req->q . '%')->paginate(10));
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
        foreach ($request->all() as $value) {
            C::Create($value);
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
