<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;

class GroupsController extends Controller
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
        if (count($request->query()) > 0) {
            return Group::where('name', 'LIKE', '%' . $request->query('name') . '%')
                ->where('tag', 'LIKE', '%' . $request->query('tag') . '%')
                ->get();
        }

        return Group::all();
    }

    public function get($identifier)
    {
        return Group::findOrFail($identifier);
    }

    public function post(Request $request)
    {
        try {
            $group = new Group();

            $group->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $group->name = $request->input('name');
            $group->tag = $request->input('tag');
            $group->save();

            return response()->json(['message' => 'Group ' . $group->name . ' has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new group.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            Group::find($id)->delete();

            return response()->json(['message' => 'The group has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected group.'], 500);
        }
    }
}
