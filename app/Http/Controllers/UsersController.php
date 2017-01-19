<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
            return User::find($identifier);
        } else {
            return User::where("username", $identifier)->first();
        }
    }
}
