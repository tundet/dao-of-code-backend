<?php

namespace App\Http\Controllers;

use App\Medium;
use App\User;
use Illuminate\Http\Request;

class MediaController extends Controller
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
            return Medium::where('title', 'LIKE', '%' . $request->query('title') . '%')
                ->where('tag', 'LIKE', '%' . $request->query('tag') . '%')
                ->where('description', 'LIKE', '%' . $request->query('description') . '%')
                ->get();
        }

        return Medium::all();
    }

    public function get($identifier)
    {
        return Medium::findOrFail($identifier);
    }

    public function post(Request $request)
    {
        try {
            $medium = new Medium();

            $medium->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $medium->email = $request->input('group_id');
            $medium->file_name = $request->input('file_name');
            $medium->title = $request->input('title');
            $medium->description = $request->input('description');
            $medium->tag = $request->input('tag');
            $medium->media_type = $request->input('media_type');
            $medium->mime_type = $request->input('mime_type');
            $medium->group_priority = $request->input('group_priority');

            $medium->save();

            return response()->json(['message' => 'Medium ' . $medium->title . ' has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new medium.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            Medium::find($id)->delete();

            return response()->json(['message' => 'The medium has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected medium.'], 500);
        }
    }
}
