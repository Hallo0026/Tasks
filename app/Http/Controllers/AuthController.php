<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            //$request->session()->regenerate();
            $access_token = $request->user()->createToken('access_token');

            return response()->json([
                'message' => 'Authenticated',
                'token' => $access_token->plainTextToken
            ], 200);
        }

        return response()->json(['message' => 'Unauthenticated'], 401);
    }


    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

}
