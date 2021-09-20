<?php

namespace App\Http\Controllers\Shop;

use DB;
use App\User;
use Illuminate\Http\Request;
use App\Models\Clients\Client;
use App\Models\Shop\Shop as B;
use App\Models\Branches\Branch;
use App\Http\Others\SampleEmpty;


use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Shop\Shop as BR;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopDropdown extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}


class ShopController extends Controller
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
            return BR::collection(B::with(['created_by', 'user'])->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    public function dropdown()
    {
        //
        return ShopDropdown::collection( User::with(['roles'])->whereHas('roles', function($q){
            return $q->where('name' , 'Shop');
        })->get() );
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
        $validatedData =  $request->validate([
            "name" => "required|max:55",
            "email" => "required",
            "password" => "required|max:100"
            // "password" => "required|confirmed"
        ]);

        $validatedData["password"] = bcrypt($validatedData["password"]);
        $User = User::create($validatedData);

        $count =  Role::where('name', 'Shop')->count();
        if ($count < 1
        ) {
            Role::create(['name' => 'Shop']);
        }
        $User->assignRole('Shop');
        $Shop =  $User->shop()->create($request->all());
        $branch =  Branch::create([ 'name' => 'Branch-1' , 'address' => 'Your location', 'shop_id' => $User->id ]);

        $User->shop_id = $User->id;
        $User->branch_id  = $branch->id;
        $User->save();

        $branch->clients()->createMany([
            ['name' => 'Walk in seller', 'type' => 'seller'],
            ['name' => 'Walk in customer', 'type' => 'customer']
        ]); 
        
        return new BR($Shop);

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
        return new BR(B::with(['user'])->find($id));
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
        // if ( B::where('id' , $id)->update( $request->all() ) )  {
        //     return new BR( B::find($id) );
        // };

        // $Shop = B::find($id);
        // return $Shop;

        $Shop = B::find($id);
        if (isset($Shop)) {
            $Shop->update(["address" => $request->address]);
            $Shop->user()->update(["name" => $request->name, "email" => $request->email, "password" => bcrypt( $request->password ) ]);
            return new BR(B::find($id));
        } else {
            abort(403, 'Not found');
        }
        // abort(403, 'Not found');
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
