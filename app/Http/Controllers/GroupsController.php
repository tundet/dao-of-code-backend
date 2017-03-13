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

    /**
     * @apiGroup            Groups
     * @apiName             GetAllGroups
     * @apiDescription      Get a list of all groups.
     * @api                 {get} /groups Get all groups
     * @apiSuccess          (200) {array} message List of groups.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "name": "My PHP Tutorials",
                                            "description": "Description for My PHP Tutorials"
                                            "tag": "php",
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 1,
                                            "name": "Useful JavaScript Code Snippets",
                                            "description": "Description for Useful JavaScript Code Snippets",
                                            "tag": "javascript",
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 3,
                                            "user_id": 2,
                                            "name": "Miscellaneous Tutorials",
                                            "description": "Description for Miscellaneous Tutorials",
                                            "tag": "cpp",
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(Request $request)
    {
        if (count($request->query()) > 0) {
            return Group::where('name', 'LIKE', '%' . $request->query('name') . '%')
                ->where('tag', 'LIKE', '%' . $request->query('tag') . '%')
                ->get();
        }

        return Group::all();
    }

    /**
     * @apiGroup            Groups
     * @apiName             GetGroup
     * @apiDescription      Get a group by ID.
     * @api                 {get} /groups/:id Get a group
     * @apiParam            {number} id ID of the group.
     * @apiSuccess          (200) {json} message Group object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "id": 1,
                                    "user_id": 1,
                                    "name": "My PHP Tutorials",
                                    "description": "Description for My PHP Tutorials",
                                    "tag": "php",
                                    "created_at": null,
                                    "updated_at": null
                                }
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Group::findOrFail($id);
    }

    /**
     * @apiGroup            Groups
     * @apiName             GetMediaOfGroup
     * @apiDescription      Get media of a group
     * @api                 {get} /groups/:id/media Get media of a group
     * @apiParam            {number} id ID of the group.
     * @apiSuccess          (200) {array} message List of media.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 1,
                                        "user_id": 1,
                                        "group_id": 1,
                                        "file_name": "2.gif",
                                        "title": "Test Image 1",
                                        "description": "This is the first test image.",
                                        "tag": "cpp",
                                        "media_type": "image",
                                        "mime_type": "image/gif",
                                        "group_priority": null,
                                        "youtube_url": null,
                                        "snippet_content": null,
                                        "created_at": null,
                                        "updated_at": null
                                    },
                                    {
                                        "id": 2,
                                        "user_id": 2,
                                        "group_id": 1,
                                        "file_name": "2.gif",
                                        "title": "Test Image 2",
                                        "description": "This is the second test image.",
                                        "tag": "cpp",
                                        "media_type": "image",
                                        "mime_type": "image/gif",
                                        "group_priority": null,
                                        "youtube_url": null,
                                        "snippet_content": null,
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $id
     * @return mixed
     */
    public function getMedia($id)
    {
        $group = Group::findOrFail($id);

        return $group->media()->orderBy('group_priority', 'asc')->get();
    }

    /**
     * @apiGroup            Groups
     * @apiName             GetLikesOfGroup
     * @apiDescription      Get likes of a group
     * @api                 {get} /groups/:id/likes Get likes of a group
     * @apiParam            {number} id ID of the group.
     * @apiSuccess          (200) {array} message List of likes.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 4,
                                        "user_id": 1,
                                        "medium_id": null,
                                        "group_id": 2,
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
        $group = Group::findOrFail($id);

        return $group->likes;
    }

    /**
     * @apiGroup            Groups
     * @apiName             GetFavoritesOfGroup
     * @apiDescription      Get favorites of a group
     * @api                 {get} /groups/:id/favorites Get favorites of a group
     * @apiParam            {number} id ID of the group.
     * @apiSuccess          (200) {array} message List of favorites.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                    "id": 6,
                                    "user_id": 3,
                                    "medium_id": null,
                                    "group_id": 1,
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
        $group = Group::findOrFail($id);

        return $group->favorites;
    }

    /**
     * @apiGroup            Groups
     * @apiName             GetLatestGroupsByTag
     * @apiDescription      Get the latest groups by tag.
     * @api                 {get} /groups/latest/:tag/:amount Get the latest groups by tag
     * @apiParam            {number} amount Amount of groups to get.
     * @apiParam            {string} tag Tag of the groups to get.
     * @apiSuccess          (200) {array} message List of groups.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                    "id": 1,
                                    "user_id": 1,
                                    "name": "My PHP Tutorials",
                                    "tag": "php",
                                    "created_at": null,
                                    "updated_at": null
                                    }
                                ]
     *
     * @param $amount
     * @return mixed
     */
    public function getLatestGroupsByTag($tag, $amount)
    {
        return Group::where('tag', $tag)->orderBy('id', 'desc')->take($amount)->get();

    }

    /**
     * @apiGroup            Groups
     * @apiName             CreateGroup
     * @apiDescription      Create a group.
     * @api                 {post} /groups Create a group
     * @apiParam            {string} name Name of the group.
     * @apiParam            {string} description Description of the group.
     * @apiParam            {string} tag Tag of the group.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The group has been created.",
                                    "id" : "1"
                                }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $group = new Group();

            $group->user_id = User::where('api_token', $request->header('x-access-token'))->value('id');
            $group->name = $request->input('name');
            $group->description = $request->input('description');
            $group->tag = $request->input('tag');
            $group->save();

            $response = [
                'message'   => 'Group ' . $group->name . ' has been created.',
                'id'        => $group->id
            ];

            return response()->json($response, 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new group.'], 500);
        }
    }

    /**
     * @apiGroup            Groups
     * @apiName             UpdateGroup
     * @apiDescription      Update a group.
     * @api                 {patch} /group/:id Update a group
     * @apiParam            {string} name (Optional) Name of the group.
     * @apiParam            {string} description (Optional) Description of the group.
     * @apiParam            {string} tag (Optional) Tag of the group.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                {
                                    "message": "Group group1 has been updated."
                                }
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function patch(Request $request, $id)
    {
        try {
            $group = Group::findOrFail($id);

            $groupHasChanged = false;

            if ($request->has('name')) {
                $group->name = $request->input('name');
                $groupHasChanged = true;
            }

            if ($request->has('description')) {
                $group->description = $request->input('description');
                $groupHasChanged = true;
            }

            if ($request->has('tag')) {
                $group->tag = $request->input('tag');

                foreach ($group->media as $medium) {
                    $medium->tag = $group->tag;
                    $medium->save();
                }

                $groupHasChanged = true;
            }

            if ($groupHasChanged) {
                $group->save();
            }

            return response()->json(['message' => 'Group ' . $group->name . ' has been updated.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to update group.' . $ex->getMessage()], 500);
        }
    }

    /**
     * @apiGroup            Groups
     * @apiName             DeleteGroup
     * @apiDescription      Delete a group.
     * @api                 {delete} /groups/:id Delete a group
     * @apiParam            {number} id ID of the group.
     * @apiSuccess          (200) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 20 OK
                                {
                                    "message": "The group has been deleted."
                                }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $group = Group::find($id);

            foreach ($group->media as $medium) {
                $medium->group_id = null;
                $medium->group_priority = null;
                $medium->save();
            }

            $group->delete();

            return response()->json(['message' => 'The group has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected group.'], 500);
        }
    }
}
