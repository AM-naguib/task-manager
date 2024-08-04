<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $userData = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);
        if($userData->fails()){
            return response()->json($userData->errors(), 401);
        }
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('web')->plainTextToken;
            return response()->json([
                "user" => $user,
                "token" => $token
            ], 200);
        }
    }

    public function register(Request $request){
        $user = Validator::make($request->all(), [
           "name" => "required",
           "username" =>["required","unique:users,username"],
           "email" => ["required","unique:users,email","email"],
           "password" => "required",
        ]);

        if($user->fails()){
            return response()->json($user->errors(), 401);
        }
        try{
            $user = User::create($user->validated());
            $token = $user->createToken('web')->plainTextToken;
            return response()->json([
                "user" => $user,
                "token" => $token
            ], 200);
        }catch (\Exception $e){
            return response()->json(["message" => $e->getMessage()], 500);
        }

    }


    public function logout(Request $request){
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
