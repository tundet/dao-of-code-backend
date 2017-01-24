<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

/**
 * Routes without authentication.
 */
$app->post('signin', 'AuthController@signin');
$app->post('users', 'UsersController@post');

/**
 * User routes.
 */
$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('users', 'UsersController@all');
    $app->get('users/{identifier}', 'UsersController@get');
    $app->put('users/{id}', 'UsersController@put');
    $app->delete('users/{id}', 'UsersController@delete');

    /**
     * User medium routes.
     */
    $app->get('users/{id}/media', 'UsersController@getMedia');

    /**
     * User group routes.
     */
    $app->get('users/{id}/groups', 'UsersController@getGroups');

    /**
     * User group routes.
     */
    $app->get('users/{id}/comments', 'UsersController@getComments');

    /**
     * Authentication routes.
     */
    $app->post('signout', 'AuthController@signout');

    /**
     * Medium routes.
     */
    $app->get('media', 'MediaController@all');
    $app->get('media/{id}', 'MediaController@get');
    $app->post('media', 'MediaController@post');
    $app->delete('media/{id}', 'MediaController@delete');

    /**
     * Medium routes.
     */
    $app->get('media/{id}/comments', 'MediaController@getComments');

    /**
     * Group routes.
     */
    $app->get('groups', 'GroupsController@all');
    $app->get('groups/{id}', 'GroupsController@get');
    $app->post('groups', 'GroupsController@post');
    $app->delete('groups/{id}', 'GroupsController@delete');

    /**
     * Comment routes.
     */
    $app->get('comments', 'CommentsController@all');
    $app->get('comments/{id}', 'CommentsController@get');
    $app->post('comments', 'CommentsController@post');
    $app->delete('comments/{id}', 'CommentsController@delete');
});