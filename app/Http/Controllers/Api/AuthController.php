<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedData =  $request->validate([
            "name" => "required|max:55",
            "email" => "required",
            "password" => "required|max:100"
            // "password" => "required|confirmed"
        ]);
        
        $validatedData["password"] = bcrypt($validatedData["password"]);
        $User = User::create($validatedData);
        $User->shop_id = 0;
        $User->branch_id = 0;
        $User->save();
        $accessToken = $User->createToken('authToken')->accessToken;

        $count =  Role::where('name', 'Admin')->count();
        if ($count < 1) {
            Role::create(['name' => 'Admin']);
        }

        $User->assignRole('Admin');

        return response(['user' => $User, 'accessToken' => $accessToken]);
    }

    public function signin(Request $request)
    {
        $loginData =  $request->validate([
            "email" => "required",
            "password" => "required|max:100"
        ]);
        

        if (!auth()->attempt($loginData)) {
            return response(["msg" => "invalid user"] , 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $user =  User::find(auth()->id());

        $shop_id = 0;
        $branch_id = 0;
        if( $user->hasRole('Admin')){
            $shop_id = $user->shop_id;
            $branch_id = $user->branch_id;
        } else if($user->hasRole('Shop') ){
            $shop_id = $user->id;
            $branch_id = $user->branches->first()->id;
        }else{
            $shop_id = $user->shop_id;
        }

        return response([ 
                          'user' => User::find(auth()->id()),
                          'accessToken' => $accessToken,
                          'roles' => $user->roles,
                          'shop_id' =>  $shop_id,
                          'branch_id' =>  $branch_id
                        ]
                       );
    }



    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function signout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
