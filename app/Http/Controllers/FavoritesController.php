<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;

class FavoritesController extends Controller
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

    public function all(Request $request)
    {
        return Favorite::all();
    }

    public function get($id)
    {
        return Favorite::findOrFail($id);
    }

    public function post(Request $request)
    {
        try {
            $favorite = new Favorite();

            $favorite->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $favorite->medium_id = $request->input('medium_id');

            $favorite->save();

            return response()->json(['message' => 'The favorite has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new favorite.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            Favorite::find($id)->delete();

            return response()->json(['message' => 'The Favorite has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected favorite.'], 500);
        }
    }
}
