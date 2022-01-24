<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\BookController;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/',  'BookController@index');
    $router->get('/{id}',  'BookController@show');
    $router->delete('/{id}',  'BookController@destroy');
    $router->patch('/{id}',  'BookController@update');
    $router->post('/save',  'BookController@store');
    $router->get('/search/{query}',  'BookController@search');
});
