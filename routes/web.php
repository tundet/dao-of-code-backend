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

    $app->get('users/{id}/media', 'UsersController@getMedia');
    $app->get('users/{id}/groups', 'UsersController@getGroups');
    $app->get('users/{id}/comments', 'UsersController@getComments');

    /**
     * Authentication routes.
     */
    $app->post('signout', 'AuthController@signout');

    /**
     * Medium routes.
     */
    $app->get('media', 'MediaController@all');
    $app->get('media/latest/{amount}', 'MediaController@getLatest');
    $app->get('media/{id}/comments/latest/{amount}', 'MediaController@getLatestComments');
    $app->post('media', 'MediaController@post');
    $app->delete('media/{id}', 'MediaController@delete');
    $app->get('media/{id}/comments', 'MediaController@getComments');
    $app->get('media/{id}/favorites', 'MediaController@getFavorites');
    $app->get('media/{id}/likes', 'MediaController@getLikes');
    $app->get('media/{id}', 'MediaController@get');

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

    /**
     * Favorite routes.
     */
    $app->get('favorites', 'FavoritesController@all');
    $app->get('favorites/{id}', 'FavoritesController@get');
    $app->post('favorites', 'FavoritesController@post');
    $app->delete('favorites/{id}', 'FavoritesController@delete');

    /**
     * Like routes.
     */
    $app->get('likes', 'LikesController@all');
    $app->get('likes/{id}', 'LikesController@get');
    $app->post('likes', 'LikesController@post');
    $app->delete('likes/{id}', 'LikesController@delete');
});