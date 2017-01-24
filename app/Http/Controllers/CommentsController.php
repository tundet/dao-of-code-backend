<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
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
        return Comment::all();
    }

    public function get($identifier)
    {
        return Comment::findOrFail($identifier);
    }

    public function post(Request $request)
    {
        try {
            $comment = new Comment();

            $comment->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $comment->file_id = $request->input('file_id');
            $comment->comment = $request->input('comment');

            $comment->save();

            return response()->json(['message' => 'The comment has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new comment.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            Comment::find($id)->delete();

            return response()->json(['message' => 'The comment has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected comment.'], 500);
        }
    }
}
