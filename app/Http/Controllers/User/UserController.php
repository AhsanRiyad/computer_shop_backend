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
        $user = User::find(auth()->user()->id);
        $user->branch_id = $request->branch_id;
        $user->save();
        return $user->refresh();
    }

    public function updateShop(Request $request)
    {
        //
        // return $request->shop_id;
        $user = User::find(auth()->user()->id);
        $user->shop_id = $request->shop_id;
        $user->save();
        return $user->refresh();
    }



}
