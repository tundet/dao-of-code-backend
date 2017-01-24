<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function all()
    {
        return User::all();
    }

    public function get($identifier)
    {
        if (is_numeric($identifier)) {
            return User::findOrFail($identifier);
        } else {
            return User::where("username", $identifier)->firstOrFail();
        }
    }

    public function getMedia($id)
    {
        return User::findOrFail($id)->media;
    }

    public function post(Request $request)
    {
        try {
            $user = new User();

            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->email = $request->input('email');

            $user->save();

            return response()->json(['message' => 'User ' . $user->username . ' has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new user.'], 500);
        }
    }
}
