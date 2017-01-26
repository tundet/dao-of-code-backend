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

    /**
     * @apiGroup            Media
     * @apiName             GetAllMedia
     * @apiDescription      Get a list of all media.
     * @api                 {get} /media Get all media
     * @apiSuccess          (200) {array} message List of media.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "group_id": null,
                                            "file_name": "test1.jpg",
                                            "title": "Test Image 1",
                                            "description": "This is the first test image.",
                                            "tag": "C++",
                                            "media_type": "image",
                                            "mime_type": "image/jpeg",
                                            "group_priority": null,
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 2,
                                            "group_id": null,
                                            "file_name": "test2.jpg",
                                            "title": "Test Image 2",
                                            "description": "This is the second test image.",
                                            "tag": "cpp",
                                            "media_type": "image",
                                            "mime_type": "image/jpeg",
                                            "group_priority": null,
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
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

    /**
     * @apiGroup            Media
     * @apiName             GetMedium
     * @apiDescription      Get a medium by ID.
     * @api                 {get} /media/:id Get a medium
     * @apiParam            {number} id ID of the medium.
     * @apiSuccess          (200) {string} message Medium object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "id": 1,
                                    "user_id": 1,
                                    "group_id": null,
                                    "file_name": "test1.jpg",
                                    "title": "Test Image 1",
                                    "description": "This is the first test image.",
                                    "tag": "C++",
                                    "media_type": "image",
                                    "mime_type": "image/jpeg",
                                    "group_priority": null,
                                    "created_at": null,
                                    "updated_at": null
                                }
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Medium::findOrFail($id);
    }


    /**
     * @apiGroup            Media
     * @apiName             GetMediumComments
     * @apiDescription      Get comments of a medium by ID.
     * @api                 {get} /media/:id/comments Get comments of a medium
     * @apiParam            {number} id ID of the medium.
     * @apiSuccess          (200) {array} message List of comments.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 3,
                                        "user_id": 3,
                                        "medium_id": 1,
                                        "comment": "The third comment.",
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $id
     * @return mixed
     */
    public function getComments($id)
    {
        return Medium::findOrFail($id)->comments;
    }

    /**
     * @apiGroup            Media
     * @apiName             GetMediumFavorites
     * @apiDescription      Get favorites of a medium by ID.
     * @api                 {get} /media/:id/favorites Get favorites of a medium
     * @apiParam            {number} id ID of the medium.
     * @apiSuccess          (200) {array} message List of favorites.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 3,
                                        "user_id": 3,
                                        "medium_id": 1,
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $id
     * @return mixed
     */
    public function getFavorites($id)
    {
        return Medium::findOrFail($id)->favorites;
    }

    /**
     * @apiGroup            Media
     * @apiName             CreateMedium
     * @apiDescription      Create a medium.
     * @api                 {post} /media Create a medium
     * @apiParam            {number} group_id (Optional) ID of the group the medium belongs to.
     * @apiParam            {string} title Title of the medium.
     * @apiParam            {string} description Description of the medium.
     * @apiParam            {string} tag A tag assigned to the medium. Used to categorize media.
     * @apiParam            {string} media_type Type of the medium ("text", "audio" or "video").
     * @apiParam            {string} mime_type (Optional) MIME type of the media.
     * @apiParam            {number} group_priority Display priority in media groups. Higher is shown first.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The medium image1 has been created."
                                }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $medium = new Medium();

            $medium->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $medium->group_id = $request->input('group_id');
            $medium->file_name = (int)(Medium::all()->last()->pluck('id') + 1) . '.' . $request->file('file')->getExtension();
            $medium->title = $request->input('title');
            $medium->description = $request->input('description');
            $medium->tag = $request->input('tag');
            $medium->media_type = $request->input('media_type');
            $medium->mime_type = $request->input('mime_type');
            $medium->group_priority = $request->input('group_priority');

            $medium->save();

            if ($request->hasFile('file') && ($medium->media_type === 'video' || $medium->media_type === 'audio')) {
                $request->file('file')->move(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR .
                    'public' . DIRECTORY_SEPARATOR . $medium->user_id, $medium->file_name);
            }

            return response()->json(['message' => 'Medium ' . $medium->title . ' has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new medium.' . $ex->getMessage()], 500);
        }
    }

    /**
     * @apiGroup            Media
     * @apiName             DeleteMedium
     * @apiDescription      Delete a medium.
     * @api                 {delete} /media/:id Delete a medium
     * @apiParam            {number} id ID of the medium.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 20 OK
                                {
                                    "message": "The medium has been deleted."
                                }
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
