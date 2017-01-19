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
 * User routes
 */
$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('users', 'UsersController@all');
    $app->get('users/{identifier}', 'UsersController@get');
    $app->post('users', 'UsersController@post');
    $app->put('users/{id}', 'UsersController@put');
    $app->delete('users/{id}', 'UsersController@delete');

    $app->post('signin', 'UsersController@signin');
    $app->post('signout', 'UsersController@signout');
    $app->post('signup', 'UsersController@signup');
});