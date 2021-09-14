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
}
