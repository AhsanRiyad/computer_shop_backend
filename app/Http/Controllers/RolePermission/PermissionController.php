<?php

namespace App\Http\Controllers\RolePermission;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Role\Role as RoleResource;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return RoleResource::collection(  Permission::paginate(10) );
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $role = Permission::create(['name' => $request->name]);
        return $role;
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
        return Permission::findById($id);
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
    public function getUsersPermissions($userId)
    {
        //
        $user =  User::find($userId);
        // return $user->roles[0]->permissions;
        $permissions = [];
        // $permission[] = $user->roles[0]->permissions;

        foreach ($user->roles as $value) {
            # code...
            $permissions[] = $value->permissions;
        }
        return $permissions[0]->merge($user->permissions);
        // return $user->permissions;
        // return array_merge($permissions[0] ,$user->permissions);


        // return $permissions[0] ?? $permissions ;
        // return $permissions;
        // return $user;
        // return $permissionNames = $user->getPermissionNames();
        // $permissions = User::with('roles')->get();
        // return $permissions;
    }
    public function givePermissionsToUser(Request $request, $userId)
    {
        //
        // return $request->permissionNames;
        $user =  User::find($userId);
        // return $user->permissions;
        // return $user->getPermissionNames();
        $user->syncPermissions($request->permissionNames);
        return response('permission given' , 200);
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
        try {
            return Permission::where('id', $id)->update(["name" => $request->name]);
        } catch (\Throwable $th) {
            abort(403, 'Can not be updated');
        }
    }
    public function dropdown()
    {
        //
        return RoleResource::collection( Permission::get(['id', 'name']) );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return Permission::destroy($id);
        } catch (\Throwable $th) {
            abort(403, 'Not found');
        }
    }
}
