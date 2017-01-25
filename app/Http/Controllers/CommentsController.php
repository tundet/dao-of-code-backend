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

    /**
     * @apiGroup            Comments
     * @apiName             GetAllComments
     * @apiDescription      Get a list of all comments.
     * @api                 {get} /comments Get all comments
     * @apiSuccess          (200) {array} message List of comments.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "medium_id": 2,
                                            "comment": "The first comment.",
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 2,
                                            "medium_id": 3,
                                            "comment": "The second comment.",
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(Request $request)
    {
        return Comment::all();
    }

    /**
     * @apiGroup            Comments
     * @apiName             GetComment
     * @apiDescription      Get a comment by ID.
     * @api                 {get} /comments/:id Get a comment
     * @apiParam            {string} id ID of the comment.
     * @apiSuccess          (200) {string} message Comment object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "id": 1,
                                    "user_id": 1,
                                    "medium_id": 2,
                                    "comment": "The first comment.",
                                    "created_at": null,
                                    "updated_at": null
                                }
     *
     * @param $identifier
     * @return mixed
     */
    public function get($identifier)
    {
        return Comment::findOrFail($identifier);
    }

    /**
     * @apiGroup            Comments
     * @apiName             CreateComment
     * @apiDescription      Create a comment.
     * @api                 {post} /comments Create a comment
     * @apiParam            {number} medium_id ID of the medium the comment belongs to.
     * @apiParam            {string} Comment Contents of the comment.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The comment has been created."
                                }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $comment = new Comment();

            $comment->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $comment->medium_id = $request->input('medium_id');
            $comment->comment = $request->input('comment');

            $comment->save();

            return response()->json(['message' => 'The comment has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new comment.'], 500);
        }
    }

    /**
     * @apiGroup            Comments
     * @apiName             DeleteComment
     * @apiDescription      Delete a comment.
     * @api                 {delete} /comments Delete a comment
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 20 OK
                                {
                                    "message": "The comment has been deleted."
                                }
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
