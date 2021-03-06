<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
     * @param $identifier
     * @return mixed
     */
    private function getUserInstance($identifier)
    {
        if (is_numeric($identifier)) {
            return User::findOrFail($identifier);
        } else {
            return User::where("username", $identifier)->firstOrFail();
        }
    }

    /**
     * @apiGroup            Users
     * @apiName             GetAllUsers
     * @apiDescription      Get a list of all users.
     * @api                 {get} /users Get all users
     * @apiSuccess          (200) {array} message List of users.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              [
                                        {
                                            "id": 1,
                                            "username": "user1",
                                            "email": "user1@example.com",
                                            "created_at": null,
                                            "updated_at": "2017-01-24 14:37:19"
                                        },
                                        {
                                            "id": 2,
                                            "username": "user2",
                                            "email": "user2@example.com",
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]

     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return User::all();
    }

    /**
     * @apiGroup            Users
     * @apiName             GetUser
     * @apiDescription      Get a user by ID or username.
     * @api                 {get} /users/:identifier Get a user
     * @apiParam            {string} identifier User ID or username.
     * @apiSuccess          (200) {string} message User object.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                    {
                                        "id": 1,
                                        "username": "user1",
                                        "email": "user1@example.com",
                                        "created_at": null,
                                        "updated_at": "2017-01-24 14:37:19"
                                    }
     *
     * @param $identifier
     * @return mixed
     */
    public function get($identifier)
    {
        return $this->getUserInstance($identifier);
    }

    /**
     * @apiGroup            Users
     * @apiName             GetUsernames
     * @apiDescription      Get a list of usernames matching use IDs.
     * @api                 {post} /get-usernames Get a list of usernames
     * @apiParam            {string} id[] One or more usernames. Send the field multiple times to get multiple usernames.
     * @apiSuccess          (200) {array} message List of usernames.
     * @apiSuccessExample   {array} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    "user1",
                                    "user2"
                                ]
     *
     * @return mixed
     */
    public function getUsernames(Request $request)
    {
        $ids = $request->get('id');

        $usernames = [];

        foreach ($ids as $id) {
            $username = User::where('id', $id)->value('username');

            $usernames[] = $username;
        }

        return $usernames;
    }

    /**
     * @apiGroup            Users
     * @apiName             GetMediaOfUser
     * @apiDescription      Get a list of media uploaded by a user.
     * @api                 {get} /users/:identifier Get media of a user
     * @apiParam            {string} identifier User ID or username.
     * @apiSuccess          (200) {json} array List of media.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                    [
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
                                        "youtube_url": null,
                                        "snippet_content": null,
                                        "created_at": null,
                                        "updated_at": null
                                        }
                                    ]
     *
     * @param $identifier
     * @return mixed
     */
    public function getMedia($identifier)
    {
        return $this->getUserInstance($identifier)->media;
    }

    /**
     * @apiGroup            Users
     * @apiName             GetGroupsOfUser
     * @apiDescription      Get a list of groups created by a user.
     * @api                 {get} /users/:identifier/groups Get groups of a user
     * @apiParam            {string} identifier User ID or username.
     * @apiSuccess          (200) {array} array List of groups.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                    [
                                        {
                                            "id": 1,
                                            "user_id": 1,
                                            "name": "My PHP Tutorials",
                                            "tag": "PHP",
                                            "created_at": null,
                                            "updated_at": null
                                        }
                                    ]
     *
     * @param $identifier
     * @return mixed
     */
    public function getGroups($identifier)
    {
        return $this->getUserInstance($identifier)->groups;
    }

    /**
     * @apiGroup            Users
     * @apiName             GetFavoritesOfUser
     * @apiDescription      Get a list of favorites of a user.
     * @api                 {get} /users/:identifier/favorites Get favorites of a user
     * @apiParam            {string} identifier User ID or username.
     * @apiSuccess          (200) {array} message List of favorites.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 1,
                                        "user_id": 1,
                                        "medium_id": 2,
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $identifier
     * @return mixed
     */
    public function getFavorites($identifier)
    {
        return $this->getUserInstance($identifier)->favorites;
    }

    /**
     * @apiGroup            Users
     * @apiName             GetFavoritesOfUserByTag
     * @apiDescription      Get a list of favorites of a user.
     * @api                 {get} /users/:identifier/favorites/:tag Get favorites of a user by tag
     * @apiParam            {string} identifier User ID or username.
     * @apiParam            {string} tag Tag of the favorites.
     * @apiSuccess          (200) {array} message List of favorites.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 1,
                                        "user_id": 1,
                                        "medium_id": 2,
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $identifier
     * @param $tag
     * @return mixed
     */
    public function getFavoritesByTag($identifier, $tag)
    {
        $favoriteMedia = $this->getUserInstance($identifier)->favorites()->where('group_id', null)->get();

        $taggedFavorites = [];

        foreach ($favoriteMedia as $favorite) {
            if ($favorite->medium->tag === $tag) {
                $taggedFavorites[] = $favorite;
            }
        }

        $favoriteGroups = $this->getUserInstance($identifier)->favorites()->where('medium_id', null)->get();

        foreach ($favoriteGroups as $favorite) {
            if ($favorite->group->tag === $tag) {
                $taggedFavorites[] = $favorite;
            }
        }

        return $taggedFavorites;
    }

    /**
     * @apiGroup            Users
     * @apiName             GetCommentsOfUser
     * @apiDescription      Get a list of comments posted by a user.
     * @api                 {get} /users/:identifier/comments Get comments of a user
     * @apiParam            {string} identifier User ID or username.
     * @apiSuccess          (200) {array} message List of comments.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
                                [
                                    {
                                        "id": 1,
                                        "user_id": 1,
                                        "medium_id": 2,
                                        "comment": "The first comment.",
                                        "created_at": null,
                                        "updated_at": null
                                    }
                                ]
     *
     * @param $identifier
     * @return mixed
     */
    public function getComments($identifier)
    {
        return $this->getUserInstance($identifier)->comments;
    }

    /**
     * @apiGroup            Users
     * @apiName             CreateUser
     * @apiDescription      Create a user.
     * @api                 {post} /users Create a user
     * @apiParam            {string} username Username of the user.
     * @apiParam            {string} password Password of the user.
     * @apiParam            {string} email Email address of the user.
     * @apiSuccess          (201) {json} message Success message
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 201 Created
                                    {
                                        "message": "User user1 has been created."
                                    }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        try {
            $user = new User();

            $user->username = strtolower($request->input('username'));
            $user->password = Hash::make($request->input('password'));
            $user->email = $request->input('email');

            $user->save();

            return response()->json(['message' => 'User ' . $user->username . ' has been created.'], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Unable to create a new user.'], 500);
        }
    }
}
