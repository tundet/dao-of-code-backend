<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Like;
use App\User;
use Illuminate\Http\Request;

class LikesController extends Controller
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
     * @apiGroup            Likes
     * @apiName             GetAllLikes
     * @apiDescription      Get a list of all likes.
     * @api                 {get} /likes Get all likes
     * @apiSuccess          (200) {array} message List of likes.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "medium_id": 2,
                                            "like": 1,
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 2,
                                            "medium_id": 3,
                                            "like": 0,
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(Request $request)
    {
        return Like::all();
    }

    /**
     * @apiGroup            Likes
     * @apiName             GetLike
     * @apiDescription      Get a Like by ID.
     * @api                 {get} /likes/:id Get a like
     * @apiParam            {number} id ID of the like.
     * @apiSuccess          (200) {json} message Like object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "id": 1,
                                    "user_id": 1,
                                    "medium_id": 2,
                                    "like": 1,
                                    "created_at": null,
                                    "updated_at": null
                                }
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Like::findOrFail($id);
    }

    /**
     * @apiGroup            Likes
     * @apiName             CreateLike
     * @apiDescription      Create a like.
     * @api                 {post} /likes Create a like
     * @apiParam            {number} user_id ID of the user the like belongs to.
     * @apiParam            {number} medium_id ID of the medium the like belongs to.
     * @apiParam            {number} like 1 if like, 0 if dislike.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The like has been created."
                                }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $like = new Like();

            $like->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $like->medium_id = $request->input('medium_id');
            $like->like = $request->input('like');

            $like->save();

            return response()->json(['message' => 'The like has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new like.'], 500);
        }
    }

    /**
     * @apiGroup            Likes
     * @apiName             DeleteLike
     * @apiDescription      Delete a like.
     * @api                 {delete} /likes/:id Delete a like
     * @apiParam            {number} id ID of the like.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 20 OK
                                {
                                    "message": "The like has been deleted."
                                }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            Favorite::find($id)->delete();

            return response()->json(['message' => 'The like has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected like.'], 500);
        }
    }
}
