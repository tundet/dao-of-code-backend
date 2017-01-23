<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        // If username was not found.
        if ($user === null) {
            return response()->json(['message' => 'Signin attempt failed.'], 401);
        }

        // If signin is successful.
        if (password_verify($request->input('password'), $user->password)) {
            $response = [
                'message' => 'You have been signed in.',
                'api_token' => bin2hex(openssl_random_pseudo_bytes(128))
            ];

            $user->save();

            return response()->json($response, 200);
        }

        return response()->json(['message' => $user->api_token], 401);
    }

    public function signout(Request $request)
    {
        $user = User::where('api_token', $request->header('x-access-token'))->first();

        $user->api_token = null;
        $user->save();

        $response = [
            'message' => 'You have been signed out.'
        ];

        return response()->json($response, 200);
    }
}
