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
     * Authentication routes.
     */
    $app->post('signout', 'AuthController@signout');

    /**
     * Medium routes.
     */
    $app->get('media', 'MediaController@all');
    $app->get('media/{id}', 'MediaController@get');
    $app->get('search/media', 'MediaController@search');
    $app->post('media', 'MediaController@post');
});