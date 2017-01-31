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

    /**
     * @apiGroup            Favorites
     * @apiName             GetAllFavorites
     * @apiDescription      Get a list of all favorites.
     * @api                 {get} /favorites Get all favorites
     * @apiSuccess          (200) {array} message List of favorites.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "medium_id": 2,
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 2,
                                            "medium_id": 3,
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(Request $request)
    {
        return Favorite::all();
    }

    /**
     * @apiGroup            Favorites
     * @apiName             GetFavorite
     * @apiDescription      Get a favorite by ID.
     * @api                 {get} /favorites/:id Get a favorite
     * @apiParam            {number} id ID of the favorite.
     * @apiSuccess          (200) {json} message Favorite object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "id": 1,
                                    "user_id": 1,
                                    "medium_id": 2,
                                    "created_at": null,
                                    "updated_at": null
                                }
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Favorite::findOrFail($id);
    }

    /**
     * @apiGroup            Favorites
     * @apiName             CreateFavorite
     * @apiDescription      Create a favorite.
     * @api                 {post} /favorites Create a favorite
     * @apiParam            {number} user_id ID of the user the favorite belongs to.
     * @apiParam            {number} medium_id ID of the medium the favorite belongs to.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The favorite has been created."
                                }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @apiGroup            Favorites
     * @apiName             DeleteFavorite
     * @apiDescription      Delete a favorite.
     * @api                 {delete} /favorites/:id Delete a favorite
     * @apiParam            {number} id ID of the favorite.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 20 OK
                                {
                                    "message": "The favorite has been deleted."
                                }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            Favorite::find($id)->delete();

            return response()->json(['message' => 'The favorite has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected favorite.'], 500);
        }
    }
}
