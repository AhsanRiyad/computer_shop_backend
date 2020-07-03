<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
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

    public function login(Request $request)
    {
        $loginData =  $request->validate([
            "email" => "email|required",
            "password" => "required|max:100"
        ]);

        if (!auth()->attempt($loginData)) {
            return response(["msg" => "invalid user"]);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'accessToken' => $accessToken]);
    }
}
