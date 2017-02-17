<?php

namespace App\Http\Controllers;

use App\Medium;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

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
                                            "tag": "cpp",
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
                                    "tag": "cpp",
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
     * @apiName             GetLatestMedia
     * @apiDescription      Get the latest media.
     * @api                 {get} /media/latest/:amount Get the latest media
     * @apiParam            {number} amount Amount of media to get.
     * @apiSuccess          (200) {array} message List of media.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 3,
                                        "user_id": 3,
                                        "group_id": null,
                                        "file_name": "test3.jpg",
                                        "title": "Test Image 3",
                                        "description": "This is the third test image.",
                                        "tag": "php",
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
     *
     * @param $amount
     * @return mixed
     */
    public function getLatest($amount)
    {
        return Medium::orderBy('id', 'desc')->take($amount)->get();
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
     * @apiName             GetLatestMediumComments
     * @apiDescription      Get the latest comments of a medium by ID.
     * @api                 {get} /media/:id/comments/latest/:amount Get the latest comments of a medium
     * @apiParam            {number} id ID of the medium.
     * @apiParam            {number} amount Amount of comments to get.
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
     * @param $amount
     * @return mixed
     */
    public function getLatestComments($id, $amount)
    {
        return Medium::find($id)->comments()->orderBy('id', 'desc')->take($amount)->get();
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
     * @apiName             GetMediumLikes
     * @apiDescription      Get likes of a medium by ID.
     * @api                 {get} /media/:id/likes Get likes of a medium
     * @apiParam            {number} id ID of the medium.
     * @apiSuccess          (200) {array} message List of likes.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 3,
                                        "user_id": 3,
                                        "medium_id": 1,
                                        "like": 1,
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $id
     * @return mixed
     */
    public function getLikes($id)
    {
        return Medium::findOrFail($id)->likes;
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
     * @apiParam            {file} file (Optional) The file object to upload.
     * @apiParam            {string} media_type Type of the medium ("text", "audio", "image", "video" or "youtube").
     * @apiParam            {string} mime_type (Optional) MIME type of the medium.
     * @apiParam            {number} group_priority (Optional) Display priority in media groups. Higher is shown first.
     * @apiParam            {string} youtube_url (Optional) YouTube embed URL. Can be used instead of uploading a file.
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
            $nextMediumId = DB::table('media')->max('id') + 1;;

            $medium = new Medium();

            $medium->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $medium->group_id = $request->input('group_id');
            $medium->title = $request->input('title');
            $medium->description = $request->input('description');
            $medium->tag = $request->input('tag');
            $medium->media_type = $request->input('media_type');
            $medium->mime_type = $request->input('mime_type');
            $medium->group_priority = $request->input('group_priority');
            $medium->youtube_url = $request->input('youtube_url');

            if ($request->hasFile('file')) {
                $fileNameParts = explode('.', $_FILES['file']['name']);
                $fileExtension = end($fileNameParts);

                $medium->file_name = $nextMediumId . '.' . $fileExtension;

                if ($medium->media_type === 'image') {
                    $this->generateThumbnails($request->file('file'), $medium->file_name);
                }

                $request->file('file')->move(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR .
                    'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'original', $medium->file_name);
            }

            $medium->save();

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

    protected function generateThumbnails($file, $fileName)
    {
        $uploadsDirectory = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public'
            . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;


        $image = Image::make($file);

        if ($image->width() >= 360) {
            $image->resize(480, 360);
            $image->save($uploadsDirectory . 'small' . DIRECTORY_SEPARATOR . $fileName);
        } else {
            $image->save($uploadsDirectory . 'small' . DIRECTORY_SEPARATOR . $fileName);
        }

        if ($image->width() >= 480) {
            $image->resize(640, 480);
            $image->save($uploadsDirectory . 'medium' . DIRECTORY_SEPARATOR . $fileName);
        } else {
            $image->save($uploadsDirectory . 'medium' . DIRECTORY_SEPARATOR . $fileName);
        }

        if ($image->width() >= 720) {
            $image->resize(960, 720);
            $image->save($uploadsDirectory . 'large' . DIRECTORY_SEPARATOR . $fileName);
        } else {
            $image->save($uploadsDirectory . 'large' . DIRECTORY_SEPARATOR . $fileName);
        }
    }
}
