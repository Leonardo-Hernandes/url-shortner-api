<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 400);
        }
        $user = auth()->user();

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expirees_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}