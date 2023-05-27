<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAll()
    {
        $users = User::all();

        return response()->json([
            'data' => [
                'users' => $users
            ]
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->validated();
        
        $input['password'] = Hash::make($input['password']);

        try {
            $response = User::create($input);

            return response()->json([
                'data' => [
                    'message' => 'User Created',
                    'user' => $response
                ]
            ]);
        } catch (\Exception $e) {
            return response('User has arleady registred', 400);
        }
    }

    public function delete(Request $request)
    {
        if ($request['email'] == null)
            return response("Email cannot be null", 400);

        try {
            User::where('email', $request['email'])->firstOrFail();

            User::where('email', $request['email'])->delete();

            return response("User Deleted", 200);
        } catch (\Exception $e) {
            return response("User not found", 404);
        }
    }
}