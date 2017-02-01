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
                                            "tag": "php",
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 2,
                                            "user_id": 1,
                                            "name": "Useful JavaScript Code Snippets",
                                            "tag": "javascript",
                                            "created_at": null,
                                            "updated_at": null
                                        },
                                        {
                                            "id": 3,
                                            "user_id": 2,
                                            "name": "Miscellaneous Tutorials",
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
     * @apiName             CreateGroup
     * @apiDescription      Create a group.
     * @api                 {post} /groups Create a group
     * @apiParam            {string} name Name of the group.
     * @apiParam            {string} tag Tag of the group.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                {
                                    "message": "The group has been created.",
     *                              "id" : "1"
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
            Group::find($id)->delete();

            return response()->json(['message' => 'The group has been deleted.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to delete the selected group.'], 500);
        }
    }
}
