<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (password_verify($request->input('password'), $user->password)) {
            $response = [
                'message' => 'You have been signed in.',
                'api_token' => bin2hex(openssl_random_pseudo_bytes(128))
            ];

            $user->api_token = $response['api_token'];
            $user->save();

            return response()->json($response, 200);
        }

        $response = [
            'message' => 'Signin attempt failed.'
        ];

        return response()->json($response, 401);
    }

    public function signout(Request $request)
    {

    }

    public function signup(Request $request)
    {

    }
}
