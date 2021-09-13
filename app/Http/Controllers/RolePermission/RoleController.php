<?php

namespace App\Http\Controllers\RolePermission;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Role::with(['permissions'])->paginate(10);
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

    //assign permission
    public function assignPermission($id , $permissionId)
    {
        //
        try {
            //code...
            $permission = Permission::findById($permissionId);
            $role = Role::findById($id);
            return $role->givePermissionTo($permission);
        } catch (\Throwable $th) {
            //throw $th;
            abort(403, 'not found');
        }
    }

    //assign multiple permission
    public function assignMultiplePermission(Request $request, $id)
    {
        //
        try {
            //code...
            $permissions =  Permission::whereIn('id' , $request->permissionIds )->get();
            $role = Role::find($id);
            $role->syncPermissions($permissions);
            return response(200);
        } catch (\Throwable $th) {
            //throw $th;
            return response(403);
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
        $role = Role::create(['name' => $request->name]);
        return $role;
    }


    public function assignRoleToUser(Request $request, $userId)
    {
        //
        $user =  User::find($userId);
        $user->syncRoles($request->roles);
        return $user;
    }


    public function getUsersRole($userId)
    {
        //
        $user =  User::find($userId);
        
        return $user->roles;
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
        return Role::findById($id);
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
        try {
            return Role::where('id', $id)->update(["name" => $request->name]);
        } catch (\Throwable $th) {
            abort(403, 'Can not be updated');
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
        try {
            return Role::destroy($id);
        } catch (\Throwable $th) {
            abort(403, 'Not found');
        }
    }
}
