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

        $user = $request->user();

        if ($user) {
            // Encontra o token atual do usuário
            //$currentToken = $user->tokens()->where('id', $user->currentAccessToken()->id)->first();
            $user->tokens()->delete();

            /*if ($currentToken) {
                // Deleta o token atual
                $currentToken->delete();
            }*/

            $request->session()->invalidate();

            return response()->json(['message' => 'Logged out'], 200);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }


}
