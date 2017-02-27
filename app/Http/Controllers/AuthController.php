<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @apiGroup            Authentication
     * @apiName             Signin
     * @apiDescription      Sign in to the application.
     * @api                 {post} /signin Sign in
     * @apiParam            {string} username Username of the user.
     * @apiParam            {string} password Password of the user.
     * @apiSuccess          (200) {string} message Success message.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              {
     *                                  "message": "You have been signed in.",
     *                                  "id": 1,
     *                                  "api_token": "3fb75d3744bebfe78965c5a9e82963832c3ad4744dc03e9188c5c982d85978ef179324162d7e2e088963409036fb4a460ef7c05f6e828b80b384f0b246fde5dff31ee7451ac83eeb9b891d4e973c918162c2aedceeaaab80399f0c137c31f8e56cb9b2456561208c6f479cb2a11bbacad1e9b80b645ae6edfdd32b9eab27a08b"
     *                              }
     * @apiError            (401) {string} message Error message.
     * @apiErrorExample     {json} Error-Response:
     *                          HTTP/1.1 401 Unauthorized
     *                              {
     *                                  "message": "Signin attempt failed.",
     *                              }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        // If username was not found.
        if ($user === null) {
            return response()->json(['message' => 'Signin attempt failed.'], 401);
        }

        // If signin is successful.
        if (password_verify($request->input('password'), $user->password)) {
            $response = [
                'message'   => 'You have been signed in.',
                'id'        => $user->id,
                'api_token' => bin2hex(openssl_random_pseudo_bytes(128))
            ];

            $user->api_token = $response['api_token'];
            $user->save();

            return response()->json($response, 200);
        }

        return response()->json(['message' => $user->api_token], 401);
    }

    /**
     * @apiGroup            Authentication
     * @apiName             Signout
     * @apiDescription      Sign out of the application.
     * @api                 {post} /signin Sign out
     * @apiSuccess          (200) {string} message Success message.
     * @apiSuccessExample   {json} Success-Response:
     *                          HTTP/1.1 200 OK
     *                              {
     *                                  "message": "You have been signed out.",
     *                              }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout(Request $request)
    {
        $user = User::where('api_token', $request->header('x-access-token'))->first();

        $user->api_token = null;
        $user->save();

        $response = [
            'message' => 'You have been signed out.'
        ];

        return response()->json($response, 200);
    }
}
