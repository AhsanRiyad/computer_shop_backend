<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Role\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function dropdown()
    {
        //
        return  Role::collection(User::get(['id', 'name', 'email']));
    }

    public function updateBranch(Request $request)
    {
        //
        return User::find(auth()->user()->id)->update(['branch_id', $request->branch_id]);
    }

    public function updateShop(Request $request)
    {
        //
        return User::find(auth()->user()->id)->update(['shop_id' , $request->shop_id]);
        
    }



}
