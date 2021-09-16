<?php

namespace App\Http\Controllers\Employees;

use DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Others\SampleEmpty;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;


use App\Models\Employees\Employee as B;
use App\Http\Resources\Employees\Employee as BR;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDropdown extends JsonResource
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
            'name' => $this->user->name
        ];
    }
}


class Employee extends Controller
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
            return BR::collection(B::with(['created_by', 'branch' , 'user'])->whereHas('branch', function ($q) use ($branch_id) {
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
        $validatedData =  $request->validate([
            "name" => "required|max:55",
            "email" => "required",
            "password" => "required|max:100",
            // "password" => "required|confirmed"
        ]);


        $validatedData["password"] = bcrypt($validatedData["password"]);
        $User = User::create($validatedData);
        $User->shop_id = auth()->user()->id;
        $User->branch_id = auth()->user()->branch_id;
        $User->save();

        $count =  Role::where('name', 'Employee')->count();
        if ($count < 1) {
            Role::create(['name' => 'Employee']);
        }

        $User->assignRole('Employee');

        $employee =  B::create($request->all());
        $employee->user_id = $User->id;
        $employee->save();

        return new BR($employee);

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
    }



    public function dropdown()
    {
        //
        return EmployeeDropdown::collection(B::all());
    }

    public function search(Request $req)
    {
        // return $req->search;

        if (B::where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->count() > 0) {
            return BR::collection(B::with(['created_by'])->where('id', 'like', '%' . $req->q . '%')->orWhere('name', 'like', '%' . $req->q . '%')->paginate(10));
        }else {
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

        // $employee = B::find($id);
        // return $employee;

        $employee = B::find($id);
        if(isset($employee)){
            $employee->update(["salary" => $request->salary]);
            $employee->user()->update(["name" => $request->name, "email" => $request->email, "password" => $request->password]);
            return new BR(B::find($id));
        }else{
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
