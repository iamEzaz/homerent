<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    $request->validate ([
        'phone' => 'required|string|unique:users,phone',
        'password' => 'required|string|min:6',
        'name' => 'nullable|string|max:255'
    ]);
    $user = User::create([
        'phone' => $request->phone,
        'name' => $request->name,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User Register Successfully',
        'data'=>[
            'user' => $user,
        ]
        ], 201);
    }

    public function login(Request $req){
        $credentials = $req->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (! $token = JWTAuth::attempt($credentials)){
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'token' => $token
        ]);
    }
}