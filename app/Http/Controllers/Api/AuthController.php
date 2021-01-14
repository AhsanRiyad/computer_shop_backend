<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedData =  $request->validate([
            "name" => "required|max:55",
            "email" => "email|required",
            "password" => "required|max:100"
            // "password" => "required|confirmed"
        ]);
        $validatedData["password"] = bcrypt($validatedData["password"]);
        $User = User::create($validatedData);

        $accessToken = $User->createToken('authToken')->accessToken;

        return response(['user' => $User, 'accessToken' => $accessToken]);
    }

    public function signin(Request $request)
    {
        $loginData =  $request->validate([
            "email" => "email|required",
            "password" => "required|max:100"
        ]);
        

        if (!auth()->attempt($loginData)) {
            return response(["msg" => "invalid user"] , 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'accessToken' => $accessToken]);
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
